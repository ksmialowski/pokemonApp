<?php

namespace App\Http\Middleware;

use App\Helpers\v1\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('app.secret_key');

        if ($request->header('X-SUPER-SECRET-KEY') !== $key) {
            return ApiResponse::error('Invalid Secret API Key.', 401, 'Unauthorized');
        }

        return $next($request);
    }
}
