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

use App\Ship\Parents\Middlewares\Middleware;
use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnsureUserHasRole extends Middleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = explode('|', $role);

        if (!$request->user()->hasRole($roles)) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
