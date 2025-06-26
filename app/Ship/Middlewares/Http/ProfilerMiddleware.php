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

namespace App\Ship\Middlewares\Http;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use App\Ship\Parents\Middlewares\Middleware;

/**
 * Class ProfilerMiddleware
 *
 * @package App\Ship\Middlewares\Http
 */
class ProfilerMiddleware extends Middleware
{
    /**
     * Handle.
     *
     * @param   Request $request
     * @param   Closure $next
     *
     * @return  mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!Config::get('debugbar.enabled')) {
            return $response;
        }

        if ($response instanceof JsonResponse && app()->bound('debugbar')) {
            $profilerData = ['_profiler' => app('debugbar')->getData()];

            $response->setData($response->getData(true) + $profilerData);
        }

        return $response;
    }
}
