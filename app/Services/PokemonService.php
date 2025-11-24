<?php

namespace App\Services;

use App\Models\BannedPokemon;
use App\Models\Pokemon;
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

        $allowedPokemons = $uniquePokemonNames->diff($bannedPokemons);

        if ($allowedPokemons->isEmpty()) {
            return [];
        }

        $localPokemons = Pokemon::query()
            ->whereIn('name', $allowedPokemons)
            ->get()
            ->map(fn($pokemon) => (object) [
                'name' => $pokemon->name,
                'height' => $pokemon->height,
                'weight' => $pokemon->weight,
                'is_custom' => true,
                'source' => 'local_custom',
            ]);


        $apiResults = collect([]);
        if ($allowedPokemons->diff($localPokemons->pluck('name'))->isNotEmpty()) {
            $responses = Http::pool(fn($pool) => $allowedPokemons->map(fn($name) => $pool->get($this->apiUrl . $name)));

            $apiResults = collect($responses)
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

        return [
            ...$localPokemons->toArray(),
            ...$apiResults->toArray(),
        ];
    }
}
