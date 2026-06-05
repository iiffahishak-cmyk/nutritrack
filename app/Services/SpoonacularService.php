<?php

// ============================================================
//  app/Services/SpoonacularService.php
//
//  Complete Spoonacular API integration for NutriTrack.
//
//  Flow diagram:
//
//  fetchAndStore($dcr, $mealTime, $cuisine)
//       │
//       ├── 1. calculateCalorieWindow($dcr)  → [min, max]
//       │
//       ├── 2. searchRecipes($params)        → raw API response
//       │        └── GET /recipes/complexSearch
//       │             ?minCalories=X &maxCalories=Y
//       │             &type=breakfast|lunch|dinner|snack
//       │             &cuisine=...
//       │             &addRecipeNutrition=true
//       │
//       ├── 3. parseNutrition($recipe)       → normalised array
//       │        └── Extracts: calories, protein, carbs, fat,
//       │                      fiber, sugar, sodium
//       │
//       ├── 4. mapToFoodItem($parsed)        → DB-ready array
//       │
//       └── 5. upsertToDatabase($items)      → saved/updated count
//                └── updateOrCreate on spoonacular_id
//                    (never creates duplicates on re-sync)
// ============================================================

namespace App\Services;

use App\Models\FoodItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class SpoonacularService
{
    // ── Spoonacular API base URL ───────────────────────────────────────────
    private const BASE_URL = 'https://api.spoonacular.com';

    // ── DCR tolerance for calorie window ──────────────────────────────────
    // ±10% as required: DCR × 0.90  →  DCR × 1.10
    private const CALORIE_TOLERANCE = 0.10;

    // ── Maximum results per API call (Spoonacular max = 100) ─────────────
    private const MAX_RESULTS = 20;

    // ── Cache duration for API responses (avoid burning free-tier quota) ──
    private const CACHE_TTL_SECONDS = 3600 * 6; // 6 hours

    // ── Spoonacular meal type → NutriTrack meal_time mapping ──────────────
    private const MEAL_TYPE_MAP = [
        'Breakfast' => 'breakfast',
        'Lunch'     => 'main course',
        'Dinner'    => 'main course',
        'Snack'     => 'snack',
        'Any'       => '',
    ];

    private const NUTRITRACK_CUISINES = [
        'Malay',
        'Chinese',
        'Indian',
        'Western',
        'Middle Eastern',
    ];

    // ── Constructor: inject API key from config ────────────────────────────
    private string $apiKey;

public function __construct(?string $apiKey = null)
{
    $this->apiKey = $apiKey ?: config('services.spoonacular.key', '');
}

    // =====================================================================
    //  PUBLIC: MAIN ENTRY POINT
    //  fetchAndStore($dcr, $mealTime, $cuisine)
    //
    //  @param  float  $dcr       User's Daily Calorie Requirement
    //  @param  string $mealTime  Breakfast | Lunch | Dinner | Snack | Any
    //  @param  string $cuisine   Malay | Chinese | Indian | Western | ''
    //  @param  int    $limit     Max recipes to fetch
    //
    //  @return array{
    //      fetched: int,          — total results from API
    //      saved: int,            — new records inserted
    //      updated: int,          — existing records refreshed
    //      skipped: int,          — records that failed parsing
    //      calorie_min: int,
    //      calorie_max: int,
    //      items: Collection      — the FoodItem models that were saved
    //  }
    // =====================================================================

    public function fetchAndStore(
        float  $dcr,
        string $mealTime = 'Any',
        string $cuisine  = '',
        int    $limit    = self::MAX_RESULTS
    ): array {
        // ── Step 1: Calculate calorie window (DCR ± 10%) ──────────────────
        [$minCal, $maxCal] = $this->calculateCalorieWindow($dcr, $mealTime);

        Log::info('Spoonacular: starting fetch', [
            'dcr'      => $dcr,
            'mealTime' => $mealTime,
            'cuisine'  => $cuisine,
            'window'   => "{$minCal}–{$maxCal} kcal",
        ]);

        // ── Step 2: Hit the Spoonacular API ───────────────────────────────
        $rawRecipes = $this->searchRecipes(
            minCalories: $minCal,
            maxCalories: $maxCal,
            mealTime:    $mealTime,
            cuisine:     $cuisine,
            limit:       $limit,
        );

        if (empty($rawRecipes)) {
            Log::warning('Spoonacular: API returned 0 recipes.', compact('minCal', 'maxCal'));
            return $this->buildResult(0, 0, 0, 0, $minCal, $maxCal, collect());
        }

        // ── Steps 3+4+5: Parse → Map → Upsert ────────────────────────────
        $saved   = 0;
        $updated = 0;
        $skipped = 0;
        $items   = collect();

        foreach ($rawRecipes as $recipe) {
            try {
                // Parse nutrition from the Spoonacular response structure
                $parsed = $this->parseNutrition($recipe);

                if (! $this->isValidNutrition($parsed)) {
                    $skipped++;
                    continue;
                }

                // Map to our food_items schema
                $mapped = $this->mapToFoodItem(
                    parsed:   $parsed,
                    mealTime: $mealTime,
                    cuisine:  $cuisine,
                    minCal:   $minCal,
                    maxCal:   $maxCal,
                );

                // Upsert into database (updateOrCreate on spoonacular_id)
                [$foodItem, $wasNew] = $this->upsertFoodItem($mapped);

                $items->push($foodItem);
                $wasNew ? $saved++ : $updated++;

            } catch (\Throwable $e) {
                Log::error('Spoonacular: failed to process recipe', [
                    'recipe_id' => $recipe['id'] ?? 'unknown',
                    'error'     => $e->getMessage(),
                ]);
                $skipped++;
            }
        }

        Log::info('Spoonacular: fetch complete', compact('saved', 'updated', 'skipped'));

        return $this->buildResult(
            count($rawRecipes), $saved, $updated, $skipped,
            $minCal, $maxCal, $items
        );
    }

    // =====================================================================
    //  STEP 1 — CALORIE WINDOW CALCULATOR
    //
  // Per-slot budgets:
// Breakfast = DCR × 25%
// Lunch     = DCR × 35%
// Dinner    = DCR × 25%
// Snack     = DCR × 15%
// Any       = full DCR
    //
    //  Then apply ±10% tolerance on the per-slot value.
    // =====================================================================

    public function calculateCalorieWindow(float $dcr, string $mealTime = 'Any'): array
    {
        $slotPercentages = [
           
    'Breakfast' => 0.25,
    'Lunch'     => 0.35,
    'Dinner'    => 0.25,
    'Snack'     => 0.15,
    'Any'       => 1.00,
        ];

        $pct      = $slotPercentages[$mealTime] ?? 1.00;
        $budget   = $dcr * $pct;

        $minCal   = (int) floor($budget * (1 - self::CALORIE_TOLERANCE));
        $maxCal   = (int) ceil($budget  * (1 + self::CALORIE_TOLERANCE));

        // Absolute floor — never search below 50 kcal (Spoonacular returns garbage)
        $minCal   = max(50, $minCal);

        return [$minCal, $maxCal];
    }

    // =====================================================================
    //  STEP 2 — API CALL: GET /recipes/complexSearch
    //
    //  Key parameters used:
    //    minCalories, maxCalories    — calorie window
    //    type                        — meal type (breakfast/main course/snack)
    //    cuisine                     — optional cuisine filter
    //    addRecipeNutrition=true     — includes full macro data in one call
    //                                  (saves a second API call per recipe)
    //    number                      — max results
    //    sort=healthiness            — prefer nutritionally balanced meals
    //    apiKey                      — your Spoonacular key
    //
    //  Responses are cached by cache key for 6 hours to protect free-tier quota.
    // =====================================================================

    private function searchRecipes(
        int    $minCalories,
        int    $maxCalories,
        string $mealTime,
        string $cuisine,
        int    $limit
    ): array {
        // Build cache key from the search parameters
        $cacheKey = "spoonacular:search:{$mealTime}:{$cuisine}:{$minCalories}:{$maxCalories}:{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use (
            $minCalories, $maxCalories, $mealTime, $cuisine, $limit
        ) {
            $params = [
                'apiKey'               => $this->apiKey,
                'minCalories'          => $minCalories,
                'maxCalories'          => $maxCalories,
                'addRecipeNutrition'   => 'true',   // critical: gets macros in same call
                'number'               => $limit,
                'sort'                 => 'healthiness',
                'sortDirection'        => 'desc',
                'instructionsRequired' => 'true',   // filter out incomplete recipes
            ];

            // Map NutriTrack meal time to Spoonacular meal type
            $spoonacularType = self::MEAL_TYPE_MAP[$mealTime] ?? '';
            if ($spoonacularType !== '') {
                $params['type'] = $spoonacularType;
            }

            // Map cuisine name
            if ($cuisine !== '') {
                $params['cuisine'] = $this->mapCuisineName($cuisine);
            }

            Log::debug('Spoonacular: API request', ['params' => $params]);

            $response = Http::timeout(30)
                ->retry(2, 500)   // retry once after 500ms on timeout
                ->get(self::BASE_URL . '/recipes/complexSearch', $params);

            if ($response->failed()) {
                Log::error('Spoonacular: API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new \RuntimeException(
                    "Spoonacular API returned HTTP {$response->status()}: " . $response->body()
                );
            }

            $data = $response->json();

            // Spoonacular wraps results in a 'results' key
            return $data['results'] ?? [];
        });
    }

    // =====================================================================
    //  STEP 3 — PARSE NUTRITION FROM API RESPONSE
    //
    //  When addRecipeNutrition=true, Spoonacular embeds nutrition under:
    //    recipe.nutrition.nutrients  — array of { name, amount, unit }
    //
    //  Nutrient names we care about (exact Spoonacular names):
    //    "Calories", "Protein", "Carbohydrates", "Fat",
    //    "Fiber", "Sugar", "Sodium"
    // =====================================================================

    public function parseNutrition(array $recipe): array
    {
        // Build a lookup map: nutrient_name => amount
        $nutrients = collect($recipe['nutrition']['nutrients'] ?? [])
            ->keyBy('name');

        $get = fn(string $key, float $default = 0.0): float =>
            (float) ($nutrients[$key]['amount'] ?? $default);

        // Extract ingredients list for allergy filtering
        $ingredientNames = collect($recipe['extendedIngredients'] ?? [])
            ->pluck('name')
            ->filter()
            ->implode(', ');

        // Extract dish types and diets as arrays
        $dishTypes = $recipe['dishTypes']  ?? [];
        $diets     = $recipe['diets']      ?? [];

        return [
            // Identity
            'spoonacular_id' => (int) $recipe['id'],
            'meal_name'      => trim($recipe['title'] ?? 'Unnamed Recipe'),
            'image_url'      => $recipe['image'] ?? null,
            'description'    => $this->shortDescription($recipe['summary'] ?? '', $recipe['title'] ?? ''),
              
            // Core nutrition (all per serving)
            'calories'   => (int) round($get('Calories')),
            'protein_g'  => round($get('Protein'),        2),
            'carbs_g'    => round($get('Carbohydrates'),  2),
            'fat_g'      => round($get('Fat'),            2),
            'fiber_g'    => round($get('Fiber'),          2),
            'sugar_g'    => round($get('Sugar'),          2),
            'sodium_mg'  => round($get('Sodium'),         2),

            // Serving info
            'servings'     => max(1, (int) ($recipe['servings'] ?? 1)),
            'serving_size' => $recipe['nutrition']['weightPerServing']['amount'] ?? null
                            ? ($recipe['nutrition']['weightPerServing']['amount'] . 'g')
                            : null,

            // Classification
            'dish_types'  => $dishTypes,
            'diets'       => $diets,
            'ingredients' => $ingredientNames,
        ];
    }

    // =====================================================================
    //  STEP 4 — MAP PARSED DATA TO food_items SCHEMA
    // =====================================================================

    private function mapToFoodItem(
        array  $parsed,
        string $mealTime,
        string $cuisine,
        int    $minCal,
        int    $maxCal
    ): array {
        return [
            // External reference
            'spoonacular_id'    => $parsed['spoonacular_id'],

            // Meal data
            'meal_name'         => $parsed['meal_name'],
            'description'       => $parsed['description'],
            'image_url'         => $parsed['image_url'],

            // Nutrition
            'calories'          => $parsed['calories'],
            'protein_g'         => $parsed['protein_g'],
            'carbs_g'           => $parsed['carbs_g'],
            'fat_g'             => $parsed['fat_g'],
            'fiber_g'           => $parsed['fiber_g'],
            'sugar_g'           => $parsed['sugar_g'],
            'sodium_mg'         => $parsed['sodium_mg'],

            // Serving
            'servings'          => $parsed['servings'],
            'serving_size'      => $parsed['serving_size'],

            // Classification
            'meal_time'         => $mealTime,
            'cuisine_type'      => $this->normalizeNutriTrackCuisine($cuisine),
            'dish_types'        => $parsed['dish_types'],  // cast to array, stored as JSON
            'diets'             => $parsed['diets'],
            'ingredients'       => $parsed['ingredients'],

            // Import context
            'source'            => 'spoonacular',
            'calorie_range_min' => $minCal,
            'calorie_range_max' => $maxCal,
            'is_verified'       => false,  // requires admin approval
            'is_active'         => true,
            'last_synced_at'    => now(),
        ];
    }

    // =====================================================================
    //  STEP 5 — UPSERT INTO DATABASE
    //
    //  Uses updateOrCreate on spoonacular_id so:
    //    • First import  → INSERT new row
    //    • Re-import     → UPDATE existing row (nutrition may have changed)
    //    • Never creates → DUPLICATES
    //
    //  Also increments sync_count for audit tracking.
    // =====================================================================

    private function upsertFoodItem(array $data): array
    {
        $existing = FoodItem::where('spoonacular_id', $data['spoonacular_id'])->first();
        $isNew    = $existing === null;

        $foodItem = FoodItem::updateOrCreate(
            ['spoonacular_id' => $data['spoonacular_id']],
            array_merge($data, [
                'sync_count' => $isNew ? 1 : ($existing->sync_count + 1),
            ])
        );

        return [$foodItem, $isNew];
    }

    // =====================================================================
    //  FETCH BY SPECIFIC SPOONACULAR ID (single recipe detail lookup)
    //
    //  Used by admin panel "Import single recipe by ID" feature.
    //  GET /recipes/{id}/information?includeNutrition=true
    // =====================================================================

    public function fetchById(int $spoonacularId): ?array
    {
        $cacheKey = "spoonacular:recipe:{$spoonacularId}";

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($spoonacularId) {
            $response = Http::timeout(15)->get(
                self::BASE_URL . "/recipes/{$spoonacularId}/information",
                [
                    'apiKey'             => $this->apiKey,
                    'includeNutrition'   => 'true',
                ]
            );

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        });
    }

    // =====================================================================
    //  BULK IMPORT FOR A FULL USER PROFILE
    //
    //  Convenience method: imports all 4 meal slots for a given DCR in one call.
    //  Useful for the admin "Bulk Import for DCR" panel feature.
    // =====================================================================

    public function fetchForProfile(float $dcr, string $cuisine = ''): array
    {
        $slots   = ['Breakfast', 'Lunch', 'Dinner', 'Snack'];
        $summary = ['total_fetched' => 0, 'total_saved' => 0, 'total_updated' => 0, 'by_slot' => []];

        foreach ($slots as $slot) {
            $result = $this->fetchAndStore(
                dcr:      $dcr,
                mealTime: $slot,
                cuisine:  $cuisine,
                limit:    10,
            );

            $summary['total_fetched']   += $result['fetched'];
            $summary['total_saved']     += $result['saved'];
            $summary['total_updated']   += $result['updated'];
            $summary['by_slot'][$slot]   = $result;
        }

        return $summary;
    }

    // =====================================================================
    //  HELPERS
    // =====================================================================

    /**
     * Keep stored cuisine values inside NutriTrack's official categories.
     */
    private function normalizeNutriTrackCuisine(?string $cuisine): ?string
    {
        $cuisine = trim((string) $cuisine);

        if ($cuisine === '' || strtolower($cuisine) === 'international') {
            return null;
        }

        foreach (self::NUTRITRACK_CUISINES as $validCuisine) {
            if (strcasecmp($cuisine, $validCuisine) === 0) {
                return $validCuisine;
            }
        }

        return null;
    }

    /**
     * Map NutriTrack cuisine names to Spoonacular cuisine query values.
     * Spoonacular accepts: "asian", "chinese", "indian", "mediterranean", etc.
     */
    private function mapCuisineName(string $cuisine): string
{
    return match (strtolower($cuisine)) {
        'malay' => 'asian',
        'chinese' => 'chinese',
        'indian' => 'indian',
        'western' => 'american,european',
        'middle eastern' => 'middle eastern',
        default => $cuisine,
    };
}

    /**
     * Validate that parsed nutrition data is usable before saving.
     * Rejects items with 0 calories or missing meal name.
     */
    private function isValidNutrition(array $parsed): bool
    {
        return
            ! empty($parsed['meal_name']) &&
            $parsed['calories']  > 0      &&
            $parsed['protein_g'] >= 0     &&
            $parsed['carbs_g']   >= 0     &&
            $parsed['fat_g']     >= 0;
    }
private function shortDescription(?string $summary, string $mealName = ''): string
{
    $fallback = 'A balanced meal option suitable for the recommendation system.';

    $text = html_entity_decode(strip_tags($summary ?? ''), ENT_QUOTES | ENT_HTML5);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    if ($text === '') {
        return $fallback;
    }

    $text = preg_replace([
        '/\bThis recipe serves \d+[^.]*\./i',
        '/\bThis recipe makes \d+[^.]*\./i',
        '/\bFor \$?[\d.,]+ per serving[^.]*\./i',
        '/\bThis recipe covers \d+%[^.]*\./i',
        '/\bIt is brought to you by [^.]*\./i',
        '/\bIt is provided by [^.]*\./i',
        '/\bFrom preparation to the plate[^.]*\./i',
        '/\bIf you have [^.]*on hand[^.]*\./i',
        '/\bIf you like this recipe[^.]*\./i',
        '/\b\d+ people (?:have made|were glad|liked)[^.]*\./i',
        '/\bTaking all factors into account[^.]*\./i',
    ], ' ', $text);

    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    if ($text === '') {
        return $fallback;
    }

    $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $skipPattern = '/\b(spoonacular|brought to you|provided by|per serving|servings?|source|score of|popular score|health score|recipe)\b/i';

    foreach ($sentences as $sentence) {
        $sentence = trim($sentence);

        if ($sentence !== '' && ! preg_match($skipPattern, $sentence)) {
            $short = $sentence;
            break;
        }
    }

    $short = $short ?? '';

    if ($short === '') {
        return $fallback;
    }

    if (! preg_match('/[.!?]$/', $short)) {
        $short .= '.';
    }

    if (strlen($short) > 180) {
        $short = substr($short, 0, 177);
        $short = preg_replace('/\s+\S*$/', '', $short);
        $short = rtrim($short, " \t\n\r\0\x0B,;:-") . '...';
    }

    return $short;
}
    /**
     * Build the standardised result array returned from fetchAndStore().
     */
    private function buildResult(
        int $fetched, int $saved, int $updated, int $skipped,
        int $minCal, int $maxCal, Collection $items
    ): array {
        return compact('fetched', 'saved', 'updated', 'skipped', 'items')
            + ['calorie_min' => $minCal, 'calorie_max' => $maxCal];
    }
}
