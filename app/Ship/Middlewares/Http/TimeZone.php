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
use Illuminate\Http\Request;
use Closure;

final class TimeZone extends Middleware
{
    public const string HEADER = 'Accept-Time-Zone';

    protected array $allowed = [
        '−12:00',
        '−11:00',
        '−10:00',
        '−09:30',
        '−09:00',
        '−08:00',
        '−07:00',
        '−06:00',
        '−05:00',
        '−04:00',
        '−03:30',
        '−03:00',
        '−02:30',
        '−02:00',
        '−01:00',
        '00:00',
        '+01:00',
        '+02:00',
        '+03:00',
        '+04:00',
        '+04:30',
        '+05:00',
        '+05:30',
        '+05:45',
        '+06:00',
        '+07:00',
        '+08:00',
        '+08:45',
        '+09:00',
        '+09:30',
        '+10:00',
        '+10:30',
        '+11:00',
        '+12:00',
        '+12:45',
        '+13:00',
        '+13:45',
        '+14:00'
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws MissingTimeZoneHeaderException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->hasHeader(self::HEADER)) {
            $this->checkHeader($request);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return void
     * @throws MissingTimeZoneHeaderException
     */
    protected function checkHeader(Request $request): void
    {
        if (!in_array($request->header(self::HEADER), $this->allowed)) {
            throw new MissingTimeZoneHeaderException();
        }
    }
}
