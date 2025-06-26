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

namespace App\Ship\Providers;

use App\Ship\Parents\Providers\MainServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;

class ShipProvider extends MainServiceProvider
{
    public array $serviceProviders = [
        QueryLoggerServiceProvider::class,
        RouteServiceProvider::class,
        SimpleTypeServiceProvider::class
    ];

    protected array $aliases = [];

    public function boot(): void
    {
        Schema::defaultStringLength(SCHEMA_DEFAULT_STRING_LENGTH);
        parent::boot();
    }

    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        parent::register();
    }
}
