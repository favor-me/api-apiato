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

use App\Ship\Tests\Fackes\Objects\TimeWindowObject;
use App\Ship\Tests\UnitTestCase;
use App\Ship\Utils\DateRange;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class DateRangeTest extends UnitTestCase
{
    public function testTimeStringToCarbon(): void
    {
        $time = DateRange::timeStringToCarbon('10:00');
        $this->assertInstanceOf(Carbon::class, $time);

        $time = DateRange::timeStringToCarbon(Carbon::now());
        $this->assertInstanceOf(Carbon::class, $time);
    }

    public function testGetStartedDayFreeTimes(): void
    {
        $freeTimes = DateRange::getStartedDayFreeTimes();

        $this->assertInstanceOf(Collection::class, $freeTimes);
        $this->assertCount(1, $freeTimes);

        $freeTimes
            ->each(function (array $freeTime) {
                $minTime = Carbon::createFromTimeString(MIN_TIME);
                $maxTime = Carbon::createFromTimeString(MAX_TIME);

                $this->assertSame($minTime->format(TIME_FORMAT_SHORT), $freeTime[KEY_FROM]);
                $this->assertSame($maxTime->format(TIME_FORMAT_SHORT), $freeTime[KEY_TO]);
            });
    }

    public function testGetStartedDayFreeTimesWithCustomTimes(): void
    {
        $minTime = '09:00';
        $maxTime = '23:00';

        $freeTimes = DateRange::getStartedDayFreeTimes($minTime, $maxTime);

        $this->assertInstanceOf(Collection::class, $freeTimes);
        $this->assertCount(1, $freeTimes);

        $freeTimes
            ->each(function (array $freeTime) use ($minTime, $maxTime) {
                $minTime = Carbon::createFromTimeString($minTime);
                $maxTime = Carbon::createFromTimeString($maxTime);

                $this->assertSame($minTime->format(TIME_FORMAT_SHORT), $freeTime[KEY_FROM]);
                $this->assertSame($maxTime->format(TIME_FORMAT_SHORT), $freeTime[KEY_TO]);
            });
    }

    public function testInvertRangeDateToFreeTime(): void
    {
        $collection = collect([
            new TimeWindowObject('09:00', '10:00'),
            new TimeWindowObject('10:00', '11:00'),
            new TimeWindowObject('13:00', '14:00'),
            new TimeWindowObject('18:00', '18:30')
        ]);

        $minTime = Carbon::createFromTimeString(MIN_TIME);
        $maxTime = Carbon::createFromTimeString(MAX_TIME);

        $freeTimes = [
            [
                KEY_FROM => $minTime->format(TIME_FORMAT_SHORT),
                KEY_TO => '09:00'
            ],
            [
                KEY_FROM => '11:00',
                KEY_TO => '13:00'
            ],
            [
                KEY_FROM => '14:00',
                KEY_TO => '18:00'
            ],
            [
                KEY_FROM => '18:30',
                KEY_TO => $maxTime->format(TIME_FORMAT_SHORT)
            ]
        ];

        $result = DateRange::invertRangeDateToFreeTime($collection);

        $this->assertSame($freeTimes, $result->values()->toArray());
    }

    public function testCanTakeFreeTime(): void
    {
        $freeTimes = collect([
            [
                KEY_FROM => '08:00',
                KEY_TO => '09:00'
            ],
            [
                KEY_FROM => '09:00',
                KEY_TO => '10:00'
            ],
            [
                KEY_FROM => '13:00',
                KEY_TO => '14:00'
            ]
        ]);

        $this->assertTrue(DateRange::canTakeFreeTime($freeTimes, '08:00', '09:00'));
        $this->assertTrue(DateRange::canTakeFreeTime($freeTimes, '13:00', '13:40'));

        $this->assertFalse(DateRange::canTakeFreeTime($freeTimes, '07:59', '09:00'));
        $this->assertFalse(DateRange::canTakeFreeTime($freeTimes, '09:10', '10:01'));
    }
}
