<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('banned', BannedPokemonController::class)->only(['index', 'store', 'destroy']);
});
