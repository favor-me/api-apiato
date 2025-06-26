<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Ship\Middlewares\Http;

use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class LocalizationMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $language = $this->getLanguage($request);

        App::setLocale($language);
        Carbon::setLocale($language);

        $response = $next($request);
        $response->headers->set('Content-Language', $language);

        return $response;
    }

    protected function getLanguage(Request $request): string
    {
        if ($request->hasHeader('Accept-Language')) {
            return substr($request->header('Accept-Language'), 0, 2);
        }

        return config('app.locale');
    }
}
