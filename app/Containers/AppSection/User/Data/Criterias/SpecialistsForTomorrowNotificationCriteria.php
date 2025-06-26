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

namespace App\Containers\AppSection\User\Data\Criterias;

use App\Containers\AppSection\User\Models\User;
use App\Containers\TimetableSection\Reservation\Foundation\Reservation as BaseReservation;
use App\Containers\TimetableSection\Reservation\Models\Reservation;
use App\Containers\TimetableSection\ReservationStatus\Models\ReservationStatus;
use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class SpecialistsForTomorrowNotificationCriteria extends Criteria
{
    /**
     * @param Builder $model
     * @param RepositoryInterface $repository
     * @return Builder
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        $joinTable = Reservation::TABLE;
        $tomorrowDate = Carbon::tomorrow();

        return $model
            ->distinct()
            ->leftJoin($joinTable, $joinTable . '.' . BaseReservation::CREATED_FOR, '=', User::TABLE . '.' . ID)
            ->whereDate($joinTable . '.' . BaseReservation::DATE_AT, $tomorrowDate)
            ->whereIn($joinTable . '.' . BaseReservation::STATUS_ID, [
                ReservationStatus::AWAITING_CONFIRMATION,
                ReservationStatus::APPOINTMENT_CONFIRMED
            ]);
    }
}
