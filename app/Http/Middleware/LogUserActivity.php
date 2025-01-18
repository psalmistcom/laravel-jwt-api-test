<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $logData = [
            'user_id' => $request->user()?->id ?? 'guest',
            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
        ];

        Log::info('User Activity:', $logData);

        return $response;
    }
}
