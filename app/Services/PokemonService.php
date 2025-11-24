<?php

namespace App\Services;

use App\Models\BannedPokemon;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('app.pokemon_api_url');
    }

    public function getPokemons(array $names)
    {
        $uniquePokemonNames = collect($names)->map(fn(string $name) => strtolower(trim($name)))->unique();

        $bannedPokemons = BannedPokemon::query()
            ->whereIn('name', $uniquePokemonNames->toArray())
            ->pluck('name');

        $notBannedPokemons = $uniquePokemonNames->diff($bannedPokemons);

        if ($notBannedPokemons->isEmpty()) {
            return [];
        }

        $responses = Http::pool(fn($pool) => $notBannedPokemons->map(fn($name) => $pool->get($this->apiUrl . $name)));

        return collect($responses)
            ->filter(fn($response) => $response && $response->successful())
            ->map(function ($response) {
                $apiData = $response->json();
                return (object) [
                    'name' => $apiData['name'],
                    'height' => $apiData['height'],
                    'weight' => $apiData['weight'],
                ];
            });
    }
}
