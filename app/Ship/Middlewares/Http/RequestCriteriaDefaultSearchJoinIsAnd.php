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

use App\Ship\Criterias\RequestCriteria;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;

class RequestCriteriaDefaultSearchJoinIsAnd extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->setDefaultSearchJoin($request);
        return $next($request);
    }

    protected function setDefaultSearchJoin(Request &$request): void
    {
        if (is_null($request->get('searchJoin'))) {
            $request->merge([
                'searchJoin' => RequestCriteria::LOGIC_AND
            ]);
        }
    }
}
