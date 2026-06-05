<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MealImageService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.pexels.key');
    }

    public function fetchImageUrl(string $mealName): ?string
    {
        if (empty($this->apiKey)) {
            Log::warning('Pexels API key is missing.');
            return null;
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->retry(2, 500)
                ->withHeaders([
                    'Authorization' => $this->apiKey,
                ])
                ->get('https://api.pexels.com/v1/search', [
                    'query' => $mealName . ' food meal',
                    'per_page' => 1,
                    'orientation' => 'landscape',
                ]);

            if (! $response->successful()) {
                Log::warning('Pexels API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            return $response->json('photos.0.src.large')
                ?? $response->json('photos.0.src.medium')
                ?? null;

        } catch (\Throwable $e) {
            Log::error('Pexels API Error: ' . $e->getMessage());
            return null;
        }
    }
}