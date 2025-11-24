<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\v1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PokemonInfo\IndexPokemonInfoRequest;
use App\Http\Resources\v1\PokemonInfoResource;
use App\Services\PokemonService;
use Illuminate\Http\JsonResponse;

class PokemonInfoController extends Controller
{
    public function index(IndexPokemonInfoRequest $request, PokemonService $service): JsonResponse
    {
        try {
            $data = $service->getPokemons($request->names ?? []);
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'An error occurred while retrieving Pokemon information.',
                500,
                'Internal Server Error'
            );
        }

        return ApiResponse::success(
            PokemonInfoResource::collection($data),
            'Pokemon information retrieved successfully.',
        );
    }
}
