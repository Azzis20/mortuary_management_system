<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Services\UserRedirectService;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'client.profile' => \App\Http\Middleware\EnsureClientHasProfile::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        // Remove 'account.type' line completely
    ]);

    $middleware->redirectGuestsTo(fn () => route('login'));
    
    $middleware->redirectUsersTo(function () {
    $route = UserRedirectService::getDashboardRoute(auth()->user());
    return route($route);  // ✅ Returns URL
});
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
