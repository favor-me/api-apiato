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

use App\Ship\Parents\Providers\MainServiceProvider;
use Laravel\Passport\PassportServiceProvider;

/**
 * Class MainServiceProvider
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 *
 * @package App\Containers\AppSection\Authentication\Providers
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class MainServiceServiceProvider extends MainServiceProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        PassportServiceProvider::class,
        AuthServiceProvider::class,
        MiddlewareServiceServiceProvider::class
    ];

    public array $aliases = [
        // 'Foo' => Bar::class,
    ];

    public function register(): void
    {
        parent::register();
    }
}
