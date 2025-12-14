<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;

class UserRedirectService
{
    public static function getDashboardRoute(User $user): string
    {
        return match($user->accountType) {
            'admin' => 'admin.dashboard',
            'client' => self::getClientRoute($user),
            'driver' => 'driver.dashboard',
            'staff' => 'staff.dashboard',
            'embalmer' => 'embalmer.dashboard',
            default => 'home',
        };
    }

    public static function redirectToDashboard(User $user): RedirectResponse
    {
        $route = self::getDashboardRoute($user);
        return redirect()->route($route);
    }

    private static function getClientRoute(User $user): string
    {
        $hasProfile = Profile::where('user_id', $user->id)->exists();
        
        return $hasProfile ? 'client.dashboard' : 'client.profile.create';
    }

    public static function clientHasProfile(User $user): bool
    {
        return Profile::where('user_id', $user->id)->exists();
    }
}