<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Password\PasswordBrokerManager;
use App\Ship\Parents\Providers\MainServiceProvider;
use Illuminate\Contracts\Foundation\Application;

final class PasswordResetServiceProvider extends MainServiceProvider
{
    public function register(): void
    {
        $this->registerPasswordBroker();
    }

    protected function registerPasswordBroker(): void
    {
        $this->app->singleton(
            'fm.auth.password',
            fn (Application $app) => new PasswordBrokerManager($app)
        );

        $this->app->bind(
            'fm.auth.password.broker',
            fn (Application $app) => $app->make('fm.auth.password')->broker()
        );
    }
}
