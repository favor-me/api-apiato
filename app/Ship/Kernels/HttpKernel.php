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

namespace App\Ship\Kernels;

use App\Ship\Middlewares\Http\Authenticate;
use App\Ship\Middlewares\Http\CanBeAuthenticated;
use App\Ship\Middlewares\Http\EncryptCookies;
use App\Ship\Middlewares\Http\EnsureUserHasRole;
use App\Ship\Middlewares\Http\InsertCreatedByForSearchQuery;
use App\Ship\Middlewares\Http\LocalizationMiddleware;
use App\Ship\Middlewares\Http\PreventRequestsDuringMaintenance;
use App\Ship\Middlewares\Http\ProcessETagHeadersMiddleware;
use App\Ship\Middlewares\Http\ProfilerMiddleware;
use App\Ship\Middlewares\Http\OwnSearchQuery;
use App\Ship\Middlewares\Http\RequestCriteriaDefaultSearchJoinIsAnd;
use App\Ship\Middlewares\Http\TrimStrings;
use App\Ship\Middlewares\Http\TrustProxies;
use App\Ship\Middlewares\Http\ValidateJsonContent;
use App\Ship\Middlewares\Http\VerifyCsrfToken;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as LaravelHttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Class HttpKernel
 *
 * @package App\Ship\Kernels
 */
class HttpKernel extends LaravelHttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Laravel middleware's
        // \App\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        LocalizationMiddleware::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
//             \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            // Note: The "throttle" Middleware is registered by the RoutesLoaderTrait in the Core
            SubstituteBindings::class,
            ValidateJsonContent::class,
            ProcessETagHeadersMiddleware::class,
            ProfilerMiddleware::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'role' => EnsureUserHasRole::class,
        // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => SetCacheHeaders::class,
        // Note: The "can" Middleware is registered by MiddlewareServiceProvider in Authorization Container
        // 'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // Note: The "guest" Middleware is registered by MiddlewareServiceProvider in Authentication Container
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'search.own_query' => OwnSearchQuery::class,
        'search.default_search_join_is_and' => RequestCriteriaDefaultSearchJoinIsAnd::class,
        'search.insert_created_by' => InsertCreatedByForSearchQuery::class,
        CanBeAuthenticated::KEY => CanBeAuthenticated::class
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * Forces non-global middleware to always be in the given order.
     *
     * @var string[]
     */
    protected $middlewarePriority = [
        EncryptCookies::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        ThrottleRequests::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
}
