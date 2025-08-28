<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deviceId = $request->header('X-Device-Id');
        $apiKey = $request->header('X-Api-Key');
        
        $request->attributes->set('device_id', $deviceId);
        $request->attributes->set('api_key', $apiKey);
        
        if(! $deviceId || ! $apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID or API Key is missing.'
            ], 400);
        }

        $response = $next($request);

        $response->headers->add([
            'X-Device-Id' => $deviceId,
            'X-Api-Key' => $apiKey
        ]);

        return $response;
    }
}
