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
    protected const string PATTERN_SYS_DATE = '/^(0[1-9]|[1-2][0-9]|3[0-1])\.(0[1-9]|1[0-2])\.[0-9]{4}$/';

    // @codingStandardsIgnoreStart
    protected const string PATTERN_SYS_DATE_TIME = '/^(0[1-9]|[1-2][0-9]|3[0-1])\.(0[1-9]|1[0-2])\.[0-9]{4} (0[0-9]|1[0-9]|2[0-3]):(0[0-9]|[1-5][0-9])$/';
    // @codingStandardsIgnoreEnd

    /**
     * @param string $date System date format. See const DATE_FORMAT.
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
     * @param string $dateTime System date format. See const DATE_TIME_FORMAT.
     * @param DateTimeZone|string|null $tz
     * @return Carbon
     * @throws InvalidSystemDateFormatException
     */
    public static function createFromSystemDateTime(string $dateTime, DateTimeZone|string $tz = null): self
    {
        if (!self::isSystemDateTimeFormat($dateTime)) {
            throw new InvalidSystemDateFormatException();
        }

        list($date, $time) = explode(' ', $dateTime);
        list($hours, $minutes) = explode(':', $time);
        list($day, $month, $year) = explode('.', $date);

        $carbon = self::createFromDate($year, $month, $day, $tz);

        $carbon
            ->hour($hours)
            ->minutes($minutes)
            ->seconds(0);

        return $carbon;
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
        return preg_match(self::PATTERN_SYS_DATE, $date);
    }

    public static function isSystemDateTimeFormat(string $date): bool
    {
        return preg_match(self::PATTERN_SYS_DATE_TIME, $date);
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
        return $this->format(DATE_FORMAT);
    }
}
