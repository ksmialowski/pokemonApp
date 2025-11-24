<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\v1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{
    public function index(): JsonResponse
    {
        return ApiResponse::success(
            Pokemon::all(),
        );
    }

    public function store(): JsonResponse
    {
        return ApiResponse::success(
            null,
        );
    }

    public function show($id): JsonResponse
    {
        $pokemon = Pokemon::findOrFail($id);

        return ApiResponse::success(
            $pokemon,
        );
    }

    public function update(Pokemon $pokemon): JsonResponse
    {
        $pokemon->update();

        return ApiResponse::success(
            $pokemon->fresh(),
            ""
        );
    }

    public function destroy($id): JsonResponse
    {
        return ApiResponse::success(
            null,
            ""
        );
    }
}
