<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

final class AdminMiddleware
{
    public function handle(Request $request, Closure $next): BaseResponse
    {
        $user = auth()->user();

        abort_unless($user !== null && $user->is_admin, 403, 'Access denied. Admin privileges required.');

        $response = $next($request);

        assert($response instanceof BaseResponse);

        return $response;
    }
}
