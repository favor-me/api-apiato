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

namespace App\Ship\Tests\Unit\Utils;

use App\Ship\Tests\UnitTestCase;
use App\Ship\Utils\WeekDay;
use InvalidArgumentException;

class WeekDayTest extends UnitTestCase
{
    public function testMaxNumberValue(): void
    {
        $this->assertSame(6, WeekDay::MAX_NUMBER);
    }

    public function testMinNumberValue(): void
    {
        $this->assertSame(0, WeekDay::MIN_NUMBER);
    }

    public function testNoTimeValue(): void
    {
        $this->assertSame('00:00', WeekDay::NO_TIME);
    }

    public function testCurrentDayNumbers(): void
    {
        for ($i = 0; $i <= WeekDay::MAX_NUMBER; $i++) {
            $day = new WeekDay($i);
            $this->assertSame($i, $day->getNumber());
            $this->assertTrue(WeekDay::check($i));
        }
    }

    public function testNoCurrentDayNumberOnMax(): void
    {
        $max = WeekDay::MAX_NUMBER + 1;
        $this->assertFalse(WeekDay::check($max));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(__('ship::exception.invalid_week_day'));
        (new WeekDay($max));
    }

    public function testNoCurrentDayNumberOnMin(): void
    {
        $min = WeekDay::MIN_NUMBER - 1;
        $this->assertFalse(WeekDay::check($min));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(__('ship::exception.invalid_week_day'));
        (new WeekDay($min));
    }
}
