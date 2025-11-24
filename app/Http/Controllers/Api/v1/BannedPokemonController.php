<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\v1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BannedPokemon\StoreBannedPokemonRequest;
use App\Http\Resources\v1\BannedPokemonResource;
use App\Models\BannedPokemon;
use Illuminate\Http\JsonResponse;

class BannedPokemonController extends Controller
{
    public function index(): JsonResponse
    {
        $bannedPokemons = BannedPokemon::query()
            ->when(request('search'), fn($query, $name) => $query->where('name', 'like', "%{$name}%"))
            ->paginate(request('per_page', 10));

        return ApiResponse::success(
            BannedPokemonResource::collection($bannedPokemons),
            200,
            'Banned Pokemons retrieved successfully.'
        );
    }

    public function store(StoreBannedPokemonRequest $request): JsonResponse
    {
        $banned = BannedPokemon::query()->firstOrCreate([
            'name' => $request->name,
        ]);

        return ApiResponse::success(
            BannedPokemonResource::make($banned),
            201,
            'Banned Pokemon created successfully.'
        );
    }

    public function destroy(BannedPokemon $bannedPokemon)
    {
        $bannedPokemon->delete();

        return ApiResponse::success(
            null,
            200,
            'Banned Pokemon deleted successfully.'
        );
    }
}
