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

namespace App\Containers\AppSection\Authorization\Providers;

use App\Ship\Parents\Providers\MainServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

/**
 * Class MainServiceProvider
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 *
 * @package App\Containers\AppSection\Authorization\Providers
 */
class MainServiceServiceProvider extends MainServiceProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        PermissionServiceProvider::class,
        MiddlewareServiceServiceProvider::class
    ];

    /**
     * Container Aliases
     */
    public array $aliases = [

    ];
}
