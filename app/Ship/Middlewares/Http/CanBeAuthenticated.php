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

class CanBeAuthenticated extends Authenticate
{
    public const KEY = 'can_be_authenticated';

    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->hasHeader('authorization')) {
            return parent::handle($request, $next, ...$guards);
        }

        return $next($request);
    }
}
