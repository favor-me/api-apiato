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

namespace App\Ship\Eloquent\Casts;

use Exception;
use Illuminate\Support\Carbon;

class DateTimeAttribute
{
    public static function setFromCustomFormat(mixed $value, string $format): mixed
    {
        if (!$value instanceof Carbon) {
            try {
                $value = Carbon::createFromFormat($format, $value);
            } catch (Exception) {
                $value = Carbon::make($value);
            }
        }

        if (client_timezone()) {
            return $value
                ->setTimezone(client_timezone())
                ->utc();
        }

        return $value;
    }

    public static function get(mixed $value): ?Carbon
    {
        if ($value instanceof Carbon) {
            return $value->setTimezone(client_timezone());
        }

        if (is_null($value)) {
            return null;
        }

        return Carbon::createFromTimeString($value)->setTimezone(client_timezone());
    }
}
