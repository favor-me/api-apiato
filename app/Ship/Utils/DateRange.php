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

namespace App\Ship\Utils;

use App\Ship\Helpers\Classes\AppHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @deprecated Please, use App\Containers\TimetableSection\Reception\Foundation\Timeline
 */
class DateRange extends AppHelper
{
    public static function canTakeFreeTime(Collection $freeTimes, mixed $startAt, mixed $finishAt): bool
    {
        $startAt = self::timeStringToCarbon($startAt);
        $finishAt = self::timeStringToCarbon($finishAt);

        $startAtTimeStamp = $startAt->getTimestamp();
        $finishAtTimeStamp = $finishAt->getTimestamp();

        foreach ($freeTimes as $freeWindow) {
            $freeWindowFromTime = strtotime($freeWindow[KEY_FROM]);
            $freeWindowToTime = strtotime($freeWindow[KEY_TO]);

            if (
                ($startAtTimeStamp >= $freeWindowFromTime && $startAtTimeStamp <= $freeWindowToTime) &&
                ($finishAtTimeStamp >= $freeWindowFromTime && $finishAtTimeStamp <= $freeWindowToTime)
            ) {
                return true;
            }
        }

        return false;
    }

    public static function invertRangeDateToFreeTime(
        Collection $collection,
        mixed $minTime = MIN_TIME,
        mixed $maxTime = MAX_TIME
    ): Collection {
        $freeTimes = self::getStartedDayFreeTimes($minTime, $maxTime);

        if ($collection->isEmpty()) {
            return $freeTimes;
        }

        $collection
            ->each(function ($item) use (&$freeTimes) {
                $itemStartAt = $item->start_at->format(TIME_FORMAT_SHORT);
                $itemFinishAt = $item->finish_at->format(TIME_FORMAT_SHORT);

                $freeTimes
                    ->each(function ($freeTime, $index) use ($item, $freeTimes, $itemStartAt, $itemFinishAt) {
                        $freeWindowFromTime = strtotime($freeTime[KEY_FROM]);
                        $freeWindowToTime = strtotime($freeTime[KEY_TO]);

                        if (
                            (
                                $item->start_at->getTimestamp() >= $freeWindowFromTime &&
                                $item->start_at->getTimestamp() <= $freeWindowToTime
                            ) &&
                            (
                                $item->finish_at->getTimestamp() >= $freeWindowFromTime &&
                                $item->finish_at->getTimestamp() <= $freeWindowToTime
                            )
                        ) {
                            $freeTimes->offsetUnset($index);

                            if ($freeTime[KEY_FROM] !== $itemStartAt) {
                                $freeTimes
                                    ->add([
                                        KEY_FROM => $freeTime[KEY_FROM],
                                        KEY_TO => $itemStartAt
                                    ]);
                            }

                            $freeTimes
                                ->add([
                                    KEY_FROM => $itemFinishAt,
                                    KEY_TO => $freeTime[KEY_TO]
                                ]);
                        }
                    });
            });

        return $freeTimes;
    }

    public static function timeStringToCarbon(mixed $time): Carbon
    {
        return Str::timeStringToCarbon($time);
    }

    public static function getStartedDayFreeTimes(mixed $minTime = MIN_TIME, mixed $maxTime = MAX_TIME): Collection
    {
        $minTime = self::timeStringToCarbon($minTime);
        $maxTime = self::timeStringToCarbon($maxTime);

        return collect([
            [
                KEY_FROM => $minTime->format(TIME_FORMAT_SHORT),
                KEY_TO => $maxTime->format(TIME_FORMAT_SHORT)
            ]
        ]);
    }
}
