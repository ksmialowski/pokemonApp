<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Middleware\SecretApiKey;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/info', [PokemonInfoController::class, 'index']);

    Route::middleware(SecretApiKey::class)->group(function () {
        Route::apiResource('banned', BannedPokemonController::class)
            ->only(['index', 'store', 'destroy']);
        Route::apiResource('pokemon', BannedPokemonController::class);
    });
});
