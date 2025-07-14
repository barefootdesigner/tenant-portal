<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MetaWeatherService
{
    protected $baseUrl = 'https://www.metaweather.com/api/location';

    public function getLocationId(string $city)
    {
        $cacheKey = 'metaweather_location_id_' . strtolower($city);
        return Cache::remember($cacheKey, 3600, function () use ($city) {
            $response = Http::get("{$this->baseUrl}/search/", ['query' => $city]);

            if ($response->ok()) {
                $data = $response->json();
                return $data[0]['woeid'] ?? null;
            }

            return null;
        });
    }

    public function getCurrentWeather(string $city)
    {
        $woeid = $this->getLocationId($city);

        if (!$woeid) {
            return null;
        }

        $cacheKey = 'metaweather_current_weather_' . $woeid;
        return Cache::remember($cacheKey, 1800, function () use ($woeid) {
            $response = Http::get("{$this->baseUrl}/{$woeid}/");

            if ($response->ok()) {
                $data = $response->json();
                return $data['consolidated_weather'][0] ?? null;
            }

            return null;
        });
    }
}
