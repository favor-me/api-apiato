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

use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Support\ServiceProvider;

class SimpleTypeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerMoney();
    }

    private function registerMoney(): void
    {
        $this->app->bind('money', Money::class);
    }
}
