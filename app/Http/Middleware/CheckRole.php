<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserRedirectService;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }

        $user = auth()->user();

        if (!in_array($user->accountType, $roles)) {
            return UserRedirectService::redirectToDashboard($user)
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}