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

namespace App\Ship\Support;

use App\Ship\Exceptions\InvalidSystemDateFormatException;
use App\Ship\Parents\Support\Carbon as ParentCarbon;
use DateTimeZone;

class Carbon extends ParentCarbon
{
    public const FIRST_MONTH_DAY = 1;

    /**
     * @param string $date System date format. See const TIMETABLE_RESERVATION_DATE_AT_FORMAT
     * @param DateTimeZone|string|null $tz
     * @return Carbon
     * @throws InvalidSystemDateFormatException
     */
    public static function createFromSystemDate(string $date, DateTimeZone|string $tz = null): self
    {
        if (!self::isSystemDateFormat($date)) {
            throw new InvalidSystemDateFormatException();
        }

        list ($day, $month, $year) = explode('.', $date);
        return self::createFromDate($year, $month, $day, $tz);
    }

    /**
     * @param mixed $date
     * @param DateTimeZone|string|null $tz
     * @return static
     * @throws InvalidSystemDateFormatException
     */
    public static function createOrGetFromSystemDate(mixed $date, DateTimeZone|string $tz = null): self
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        return Carbon::createFromSystemDate($date, $tz);
    }

    public static function isSystemDateFormat(string $date): bool
    {
        return preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\.(0[1-9]|1[0-2])\.[0-9]{4}$/', $date);
    }

    public static function withLeadingZero(int $number): string
    {
        return ($number < 10 ? '0' : '') . $number;
    }

    /**
     * Get the system weekday from 0 (Monday) to 6 (Sunday).
     *
     * @return int
     */
    public function systemWeekday(): int
    {
        return $this->isoWeekday() - 1;
    }

    public function toSystemTimeString(bool $short = true): string
    {
        $format = $short ? TIME_FORMAT_SHORT : TIME_FORMAT;
        return $this->format($format);
    }

    public function toSystemDateString(): string
    {
        return $this->format(TIMETABLE_RESERVATION_DATE_AT_FORMAT);
    }
}
