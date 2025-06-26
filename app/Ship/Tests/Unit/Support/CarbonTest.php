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

namespace App\Ship\Tests\Unit\Support;

use App\Ship\Exceptions\InvalidSystemDateFormatException;
use App\Ship\Support\Carbon;
use App\Ship\Tests\UnitTestCase;

class CarbonTest extends UnitTestCase
{
    public function testSystemWeekday(): void
    {
        $date = Carbon::create(2023, 01, 2);
        $this->assertSame(0, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 3);
        $this->assertSame(1, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 4);
        $this->assertSame(2, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 5);
        $this->assertSame(3, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 6);
        $this->assertSame(4, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 7);
        $this->assertSame(5, $date->systemWeekday());

        $date = Carbon::create(2023, 01, 8);
        $this->assertSame(6, $date->systemWeekday());
    }

    public function testToSystemDateString(): void
    {
        $now = Carbon::now();
        $this->assertSame($now->format(TIMETABLE_RESERVATION_DATE_AT_FORMAT), $now->toSystemDateString());
    }

    public function testIsSystemDateFormat(): void
    {
        $this->assertFalse(Carbon::isSystemDateFormat('10.23.2010'));
        $this->assertFalse(Carbon::isSystemDateFormat('32.10.2010'));
        $this->assertFalse(Carbon::isSystemDateFormat('10-10-2010'));
        $this->assertTrue(Carbon::isSystemDateFormat('10.10.2010'));
    }

    public function testCreateFromSystemDateWithFailedSystemDateFormat(): void
    {
        $this->expectException(InvalidSystemDateFormatException::class);
        $this->expectExceptionMessage(__('ship::exception.invalid_system_date_format'));
        Carbon::createFromSystemDate('32.10.2010');
    }

    public function testCreateFromSystemDate(): void
    {
        $systemDateFormat = Carbon::now()->toSystemDateString();
        $date = Carbon::createFromSystemDate($systemDateFormat);
        $this->assertInstanceOf(Carbon::class, $date);
    }
}
