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

namespace App\Containers\ShiftSection\Shift\Tests\Functional\API;

use AllowDynamicProperties;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

#[AllowDynamicProperties]
final class GetAllShiftsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $baseCount = ShiftModel::count();

        $models = ShiftModel::factory()
            ->count(3)
            ->create();

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('meta.pagination.total', $models->count() + $baseCount)
                    ->etc()
            );
    }

    public function testSuccessWorker(): void
    {
        $this->testingUser = null;

        $this->getTestingOrganizationUser(null, [
            ROLES => [
                RoleModel::ORGANIZATION_WORKER
            ]
        ]);

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        ShiftModel::factory()
            ->count(3)
            ->create([
                CREATED_BY => $user->id
            ]);

        $workerShifts = ShiftModel::factory()
            ->count(2)
            ->create([
                CREATED_BY => $this->testingUser->id
            ]);

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $workerShifts->count())
                    ->etc()
            );
    }
}
