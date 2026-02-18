<?php

namespace App\Modules\Auth\Service;

use App\Modules\Auth\Contracts\AuthServiceContract;

class AuthServiceFactory
{
    public static function create(?string $guard = null): AuthServiceContract
    {
        $guard = $guard ?? config('auth.defaults.guard');

        return match ($guard) {
            'web' => new WebAuthService(),
            'api' => new ApiAuthService(),
            default => throw new \InvalidArgumentException("Unsupported guard: {$guard}"),
        };
    }
}
