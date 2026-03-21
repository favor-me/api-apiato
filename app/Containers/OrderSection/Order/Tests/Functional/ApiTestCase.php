<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\OrderSection\Order\Tests\Functional;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\OrderSection\Order\Tests\FunctionalTestCase;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use Illuminate\Support\Carbon;

abstract class ApiTestCase extends FunctionalTestCase
{
    public function getCompletedStatus(): StatusModel
    {
        return StatusModel::where(Status::SLUG, StatusModel::COMPLETED)->first();
    }

    public function getTestingOrganizationUser(?array $userDetails = null, ?array $access = null): UserModel
    {
        $nowShift = null;
        if (array_key_exists('now_shift', (array)$userDetails)) {
            $nowShift = $userDetails['now_shift'];
            unset($userDetails['now_shift']);
        }

        $user = parent::getTestingOrganizationUser($userDetails, $access);

        if ($nowShift  === true) {
            $this->createUserNowShift($user);
        }

        return $user;
    }

    protected function createUserNowShift(UserModel $user): ShiftModel
    {
        $startAt = Carbon::now()->subHours(4);
        $finishAt = Carbon::now()->addHours(4);

        return ShiftModel::factory()
            ->create([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt,
                CREATED_BY => $user->id
            ]);
    }
}
