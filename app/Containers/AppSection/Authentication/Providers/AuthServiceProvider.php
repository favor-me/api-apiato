<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\Authentication\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\DeferrableProvider;
use Laravel\Passport\Passport;
use App\Ship\Parents\Providers\AuthServiceProvider as ParentAuthProvider;

/**
 * Class AuthProvider
 *
 * This class is provided by Laravel as default provider,
 * to register authorization policies.
 *
 * A.K.A App\Providers\AuthServiceProvider.php
 *
 * @package App\Containers\AppSection\Authentication\Providers
 */
class AuthServiceProvider extends ParentAuthProvider implements DeferrableProvider
{
    protected $policies = [];

    public function boot(): void
    {
        parent::boot();

        $this->configPassport();
    }

    private function configPassport(): void
    {
        if (config('apiato.api.enabled-implicit-grant')) {
            Passport::enableImplicitGrant();
        }

        Passport::tokensExpireIn(Carbon::now()->addMinutes(config('apiato.api.expires-in')));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(config('apiato.api.refresh-expires-in')));
    }

    public function register(): void
    {
        parent::register();

        Passport::ignoreRoutes();
    }
}
