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

use App\Containers\AppSection\User\Tasks\CountSpecialistsForTomorrowNotificationTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\TimetableSection\Reservation\Models\Reservation;
use App\Containers\TimetableSection\Reservation\Foundation\Reservation as BaseReservation;
use App\Containers\TimetableSection\ReservationStatus\Models\ReservationStatus;

final class CountSpecialistsForTomorrowNotificationTaskTest extends UnitTestCase
{
    public function test(): void
    {
        Reservation::factory()
            ->confirmedStatus()
            ->create();

        Reservation::factory()
            ->tomorrow()
            ->confirmedStatus()
            ->create();

        $reservation = Reservation::factory()
            ->tomorrow()
            ->create([
                BaseReservation::STATUS_ID => ReservationStatus::AWAITING_CONFIRMATION
            ]);

        Reservation::factory()
            ->tomorrow()
            ->create([
                BaseReservation::CREATED_FOR => $reservation->created_for,
                BaseReservation::STATUS_ID => ReservationStatus::AWAITING_CONFIRMATION
            ]);

        Reservation::factory()
            ->create([
                BaseReservation::STATUS_ID => ReservationStatus::APPOINTMENT_CANCELLED
            ]);

        $result = app(CountSpecialistsForTomorrowNotificationTask::class)->run();

        $this->assertSame(2, $result);
    }
}
