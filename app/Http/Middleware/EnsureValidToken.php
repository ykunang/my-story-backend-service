<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->header('x-api-key') === config('app.apiKey')) {
            return $next($request);
        }
        return sendResponse(
            httpCode: HttpResponse::HTTP_UNAUTHORIZED,
            message: 'invalid apikey was provided',
            statusCode: 'ERROR',
        );
    }
}
