<?php

// ============================================================
//  app/Http/Controllers/FoodLoggerController.php
//
//  NutriTrack AI Food Logger
//  - Analyze food description using OpenRouter first when available
//  - Fallback to Gemini if backup AI is unavailable
//  - Save AI-estimated meals to meal_logs
//  - Adds healthiness estimate for every AI-analyzed food
// ============================================================

namespace App\Http\Controllers;

use App\Models\MealLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FoodLoggerController extends Controller
{
    private const GEMINI_MODEL = 'gemini-2.0-flash';

    private const OR_MODEL = 'google/gemini-2.5-flash';

    public function index()
    {
        return view('meals.food-logger');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'meal_time' => ['required', 'string', 'in:Breakfast,Lunch,Dinner,Snack'],
            'food_description' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        $mealTime = $request->input('meal_time');
        $foodDescription = trim($request->input('food_description'));

        // Rate limit guard: 1 request every 5 seconds per user
        $rateLimitKey = 'food_logger_' . auth()->id();

        if (Cache::has($rateLimitKey)) {
            return back()->withInput()->withErrors([
                'api' => 'Please wait a moment before analyzing again. The AI needs a few seconds between requests.',
            ]);
        }

        Cache::put($rateLimitKey, true, 5);

        $prompt = $this->buildPrompt($foodDescription);

        $geminiKey = config('services.gemini.key');
        $openrouterKey = config('services.openrouter.key');

        $result = null;
        $error = null;
        $usedApi = null;

        if (empty($geminiKey) && empty($openrouterKey)) {
            return back()->withInput()->withErrors([
                'api' => 'AI key is missing. Add GEMINI_API_KEY or OPENROUTER_API_KEY in Railway Variables.',
            ]);
        }

        // Try OpenRouter first when configured to avoid Gemini quota limits during demos.
        if (! empty($openrouterKey)) {
            [$result, $error] = $this->callOpenRouter($openrouterKey, $prompt);

            if ($result) {
                $usedApi = 'OpenRouter';
            } else {
                Log::warning('OpenRouter failed, trying Gemini fallback', [
                    'error' => $error,
                ]);
            }
        }

        // Try Gemini fallback.
        if (! $result && ! empty($geminiKey)) {
            [$result, $error] = $this->callGemini($geminiKey, $prompt);

            if ($result) {
                $usedApi = 'Gemini';
            }
        }

        if (! $result) {
            return back()->withInput()->withErrors([
                'api' => $error ?? 'AI service is unavailable. Please try again later.',
            ]);
        }

        $nutrition = $this->parseAndSanitize($result, $foodDescription);

        if (! $nutrition) {
            return back()->withInput()->withErrors([
                'api' => 'AI returned unreadable data. Please describe your meal more specifically, for example: "200g grilled chicken with 1 cup rice".',
            ]);
        }

        $nutrition['api_used'] = $usedApi;
        $nutrition['meal_time'] = $mealTime;

        // Healthiness estimate works for every analyzed food
        $nutrition['healthiness'] = $this->evaluateHealthiness($nutrition, $mealTime);

        return view('meals.food-logger', compact('nutrition'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'meal_time' => ['required', 'string', 'in:Breakfast,Lunch,Dinner,Snack'],
            'meal_name' => ['required', 'string', 'max:255'],
            'total_calories' => ['required', 'integer', 'min:0'],
            'protein_g' => ['nullable', 'numeric', 'min:0'],
            'carbs_g' => ['nullable', 'numeric', 'min:0'],
            'fat_g' => ['nullable', 'numeric', 'min:0'],
        ]);

        MealLog::create([
            'user_id' => auth()->id(),
            'meal_id' => null,
            'meal_time' => $validated['meal_time'],
            'date' => now()->toDateString(),
            'meal_name' => $validated['meal_name'],
            'calories' => $validated['total_calories'],
            'protein_g' => $validated['protein_g'] ?? 0,
            'carbs_g' => $validated['carbs_g'] ?? 0,
            'fat_g' => $validated['fat_g'] ?? 0,
            'source' => 'ai_logger',
        ]);

        return redirect()
            ->route('diary.index')
            ->with('success', 'AI meal saved to your diary.');
    }

    private function callGemini(string $apiKey, string $prompt): array
    {
        try {
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/'
                . self::GEMINI_MODEL
                . ':generateContent?key='
                . $apiKey;

            $response = Http::timeout(25)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.1,
                        'maxOutputTokens' => 800,
                    ],
                ]);

            if ($response->status() === 429) {
                return [null, 'AI quota is currently full. Please try again later or use the backup AI key.'];
            }

            if ($response->failed()) {
                return [null, "Gemini error HTTP {$response->status()}."];
            }

            $text = $response->json('candidates.0.content.parts.0.text') ?? '';

            return [trim($text) ?: null, 'Gemini returned empty response.'];
        } catch (\Exception $e) {
            return [null, 'Gemini connection error: ' . $e->getMessage()];
        }
    }

    private function callOpenRouter(string $apiKey, string $prompt): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => config('app.url', 'http://localhost'),
                    'X-Title' => 'NutriTrack Food Logger',
                ])
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => self::OR_MODEL,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a nutritionist AI. You ONLY respond with raw JSON. No markdown, no explanations, just JSON.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'max_tokens' => 800,
                    'temperature' => 0.1,
                ]);

            if ($response->status() === 429) {
                return [null, 'Backup AI quota is currently full. Please try again later.'];
            }

            if ($response->failed()) {
                return [null, "OpenRouter error HTTP {$response->status()}."];
            }

            $text = $response->json('choices.0.message.content') ?? '';

            return [trim($text) ?: null, 'OpenRouter returned empty response.'];
        } catch (\Exception $e) {
            return [null, 'OpenRouter connection error: ' . $e->getMessage()];
        }
    }

    private function buildPrompt(string $food): string
    {
        return <<<PROMPT
You are a professional nutritionist AI for NutriTrack, a Malaysian meal planning app.

The user described: "{$food}"

Return ONLY a raw JSON object. No markdown, no code fences, no explanation before or after.

{
  "meal_name": "Short descriptive name",
  "total_calories": 0,
  "protein_g": 0.0,
  "carbs_g": 0.0,
  "fat_g": 0.0,
  "fiber_g": 0.0,
  "sugar_g": 0.0,
  "sodium_mg": 0.0,
  "serving_note": "Brief note about portions",
  "confidence": "high",
  "items": [
    { "name": "Food name", "quantity": "200g", "calories": 0 }
  ]
}

IMPORTANT:
- Return ONLY the JSON object.
- confidence must be: high, medium, or low.
- All nutrition values must be numbers.
- Estimate Malaysian foods realistically when mentioned.
PROMPT;
    }

    private function parseAndSanitize(string $rawText, string $foodDescription): ?array
    {
        $clean = preg_replace('/^```(?:json)?\s*/im', '', $rawText);
        $clean = preg_replace('/```\s*$/im', '', $clean);
        $clean = trim($clean);

        if (! str_starts_with($clean, '{')) {
            preg_match('/\{.*\}/s', $clean, $matches);
            $clean = $matches[0] ?? $clean;
        }

        $data = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data['total_calories'])) {
            Log::error('AI JSON parse failed', [
                'raw' => $rawText,
                'error' => json_last_error_msg(),
            ]);

            return null;
        }

        return [
            'meal_name' => htmlspecialchars($data['meal_name'] ?? 'Your Meal', ENT_QUOTES),
            'total_calories' => (int) ($data['total_calories'] ?? 0),
            'protein_g' => (float) ($data['protein_g'] ?? 0),
            'carbs_g' => (float) ($data['carbs_g'] ?? 0),
            'fat_g' => (float) ($data['fat_g'] ?? 0),
            'fiber_g' => (float) ($data['fiber_g'] ?? 0),
            'sugar_g' => (float) ($data['sugar_g'] ?? 0),
            'sodium_mg' => (float) ($data['sodium_mg'] ?? 0),
            'serving_note' => htmlspecialchars($data['serving_note'] ?? '', ENT_QUOTES),
            'confidence' => in_array($data['confidence'] ?? '', ['high', 'medium', 'low'])
                ? $data['confidence']
                : 'medium',
            'items' => array_map(fn ($item) => [
                'name' => htmlspecialchars($item['name'] ?? '', ENT_QUOTES),
                'quantity' => htmlspecialchars($item['quantity'] ?? '', ENT_QUOTES),
                'calories' => (int) ($item['calories'] ?? 0),
            ], $data['items'] ?? []),
            'food_description' => $foodDescription,
        ];
    }

    private function evaluateHealthiness(array $nutrition, string $mealTime): array
    {
        $calories = (float) ($nutrition['total_calories'] ?? 0);
        $protein = (float) ($nutrition['protein_g'] ?? 0);
        $carbs = (float) ($nutrition['carbs_g'] ?? 0);
        $fat = (float) ($nutrition['fat_g'] ?? 0);
        $fiber = (float) ($nutrition['fiber_g'] ?? 0);
        $sugar = (float) ($nutrition['sugar_g'] ?? 0);
        $sodium = (float) ($nutrition['sodium_mg'] ?? 0);

        $score = 100;
        $reasons = [];
        $suggestions = [];

        $calorieRanges = [
            'Breakfast' => [250, 500],
            'Lunch' => [400, 700],
            'Dinner' => [400, 700],
            'Snack' => [100, 300],
        ];

        [$minCal, $maxCal] = $calorieRanges[$mealTime] ?? [300, 700];

        if ($calories < $minCal) {
            $score -= 8;
            $reasons[] = 'Calories are quite low for this meal time.';
            $suggestions[] = 'Add a balanced side such as fruit, vegetables, egg, yogurt, or whole grains if this is your main meal.';
        } elseif ($calories > $maxCal) {
            $score -= 18;
            $reasons[] = 'Calories are higher than the usual range for this meal time.';
            $suggestions[] = 'Consider reducing portion size or choosing less oily cooking methods.';
        } else {
            $reasons[] = 'Calories are within a reasonable range for this meal time.';
        }

        if ($protein >= 15) {
            $reasons[] = 'Protein content is acceptable.';
        } else {
            $score -= 10;
            $reasons[] = 'Protein is quite low.';
            $suggestions[] = 'Add lean protein such as egg, chicken, fish, tofu, tempeh, beans, or yogurt.';
        }

        if ($fat > 30) {
            $score -= 15;
            $reasons[] = 'Fat content is high.';
            $suggestions[] = 'Reduce fried foods, creamy sauces, or excess oil.';
        } elseif ($fat > 20) {
            $score -= 8;
            $reasons[] = 'Fat content is moderate to high.';
        }

        if ($sugar > 25) {
            $score -= 15;
            $reasons[] = 'Sugar content is high.';
            $suggestions[] = 'Reduce sweet drinks, desserts, condensed milk, or added sugar.';
        } elseif ($sugar > 12) {
            $score -= 6;
            $reasons[] = 'Sugar content is moderate.';
        }

        if ($sodium > 1000) {
            $score -= 18;
            $reasons[] = 'Sodium is high.';
            $suggestions[] = 'Use less salty sauce, soy sauce, processed foods, anchovies, or seasoning powder.';
        } elseif ($sodium > 700) {
            $score -= 8;
            $reasons[] = 'Sodium is moderate to high.';
        }

        if ($fiber >= 5) {
            $reasons[] = 'Fiber content is good.';
        } else {
            $score -= 8;
            $reasons[] = 'Fiber is quite low.';
            $suggestions[] = 'Add vegetables, fruits, beans, oats, brown rice, or wholegrain options.';
        }

        if ($carbs > 90 && $protein < 15) {
            $score -= 10;
            $reasons[] = 'The meal is high in carbohydrates but low in protein.';
            $suggestions[] = 'Balance the meal with more protein and vegetables.';
        }

        $score = max(0, min(100, $score));

        if ($score >= 75) {
            $label = 'Healthy Choice';
            $level = 'healthy';
            $summary = 'This meal looks generally balanced based on the estimated nutrition values.';
        } elseif ($score >= 50) {
            $label = 'Moderate Choice';
            $level = 'moderate';
            $summary = 'This meal is acceptable, but some parts may need portion control or healthier adjustments.';
        } else {
            $label = 'Less Healthy Choice';
            $level = 'less_healthy';
            $summary = 'This meal may be less healthy due to high calories, sodium, sugar, fat, or low fiber/protein.';
        }

        if (empty($suggestions)) {
            $suggestions[] = 'Keep the portion balanced and include vegetables or fruit when possible.';
        }

        return [
            'label' => $label,
            'level' => $level,
            'score' => $score,
            'summary' => $summary,
            'reasons' => array_values(array_unique($reasons)),
            'suggestions' => array_values(array_unique($suggestions)),
        ];
    }
}
