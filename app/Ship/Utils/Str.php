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

namespace App\Ship\Utils;

use Illuminate\Support\Carbon;

class Str
{
    public static function toPath(mixed $string): string
    {
        return implode('/', mb_str_split((string)$string));
    }

    public static function toPhoneNumber($phoneNumber, array $search = []): int
    {
        $search = array_merge($search, [' ', '-', '+', '(', ')']);
        $number = trim(str_replace($search, null, $phoneNumber));

        if (preg_match('/^\+/', $phoneNumber)) {
            return (int)$number;
        }

        if (preg_match('/^(?!7)/', $number)) {
            return (int)substr_replace($number, 7, 0, 1);
        }

        return (int)$number;
    }

    public static function timeStringToCarbon(mixed $time): Carbon
    {
        return !$time instanceof Carbon ? Carbon::createFromTimeString($time) : $time;
    }
}
