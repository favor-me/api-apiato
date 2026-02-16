<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Middlewares\Http;

use App\Ship\Exceptions\MissingTimeZoneHeaderException;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;

class AcceptTimeZone extends Middleware
{
    public const string KEY = 'accept_time_zone';
    public const string HEADER = 'Accept-Time-Zone';

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws MissingTimeZoneHeaderException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->hasHeader(self::HEADER)) {
            throw new MissingTimeZoneHeaderException();
        }

        return $next($request);
    }
}
