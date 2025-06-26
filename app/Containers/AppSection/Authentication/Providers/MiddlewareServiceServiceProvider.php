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

use App\Ship\Middlewares\Http\RedirectIfAuthenticated;
use App\Ship\Parents\Providers\MiddlewareServiceProvider;

/**
 * Class MiddlewareServiceProvider
 *
 * @package App\Containers\AppSection\Authentication\Providers
 */
class MiddlewareServiceServiceProvider extends MiddlewareServiceProvider
{
    /**
     * Middleware group map.
     *
     * @var array
     */
    protected array $middlewareGroups = [
        'web' => [
            // ..
        ],
        'api' => [
            // ..
        ],
    ];

    /**
     * Middleware map.
     *
     * @var array
     */
    protected array $middlewares = [
        // ..
    ];

    /**
     * Middleware route.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        // apiato User Authentication middleware for Web Pages
        'guest' => RedirectIfAuthenticated::class
    ];
}
