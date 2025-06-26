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

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\User\Tasks\GetAllSpecialistsForTomorrowNotificationTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\TimetableSection\Reservation\Foundation\Reservation as BaseReservation;
use App\Containers\TimetableSection\Reservation\Models\Reservation;
use App\Containers\TimetableSection\ReservationStatus\Models\ReservationStatus;
use App\Ship\Database\Eloquent\Collection;

final class GetAllSpecialistsForTomorrowNotificationTaskTest extends UnitTestCase
{
    public function test(): void
    {
        $reservationOne = Reservation::factory()
            ->tomorrow()
            ->confirmedStatus()
            ->create();

        Reservation::factory()
            ->confirmedStatus()
            ->create();

        $reservationTwo = Reservation::factory()
            ->tomorrow()
            ->create([
                BaseReservation::STATUS_ID => ReservationStatus::AWAITING_CONFIRMATION
            ]);

        Reservation::factory()
            ->create([
                BaseReservation::STATUS_ID => ReservationStatus::APPOINTMENT_CANCELLED
            ]);

        Reservation::factory()
            ->tomorrow()
            ->create([
                BaseReservation::CREATED_FOR => $reservationTwo->created_for,
                BaseReservation::STATUS_ID => ReservationStatus::AWAITING_CONFIRMATION
            ]);

        $result = app(GetAllSpecialistsForTomorrowNotificationTask::class)->run(10);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);

        $this->assertSame([
            $reservationOne->created_for,
            $reservationTwo->created_for
        ], $result->pluck(ID)->toArray());
    }
}
