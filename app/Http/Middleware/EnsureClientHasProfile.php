<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserRedirectService;

class EnsureClientHasProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Only check for clients
        if ($user->accountType === 'client') {
            // Allow access to profile creation routes
            if ($request->routeIs('client.profile.*')) {
                return $next($request);
            }

            // Check if profile exists
            if (!UserRedirectService::clientHasProfile($user)) {
                return redirect()->route('client.profile.create')
                    ->with('info', 'Please complete your profile to continue.');
            }
        }

        return $next($request);
    }
}