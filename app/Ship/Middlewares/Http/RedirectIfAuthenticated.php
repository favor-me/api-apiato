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
use Illuminate\Support\Facades\Auth;
use App\Ship\Parents\Providers\RouteServiceProvider;

/**
 * Class RedirectIfAuthenticated
 *
 * @package App\Ship\Middlewares\Http
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param   Request $request
     * @param   Closure $next
     * @param   string|null ...$guards
     *
     * @return  mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
