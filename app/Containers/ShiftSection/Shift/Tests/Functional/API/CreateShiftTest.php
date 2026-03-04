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
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

#[AllowDynamicProperties]
final class CreateShiftTest extends ApiTestCase
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
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testWithoutAccess(): void
    {
        $this->testingUser = null;

        $this->getTestingUser(null, [
            ROLES => '',
            PERMISSIONS => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $startAt = Carbon::now();
        $finishAt = Carbon::now()->addHours(8);

        $data = [
            Shift::START_AT => $startAt->format(DATE_TIME_FORMAT),
            Shift::FINISH_AT => $finishAt->format(DATE_TIME_FORMAT)
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, ShiftModel::RESOURCE_KEY)
                    ->where('data.' . CREATED_BY, $this->testingUser->getHashedKey())
                    ->where(
                        'data.' . Shift::START_AT . '.date_for_human',
                        $startAt->format(Transformer::HUMAN_DATE_FORMAT)
                    )
                    ->where(
                        'data.' . Shift::START_AT . '.time_short',
                        $startAt->format(TIME_FORMAT_SHORT)
                    )
                    ->where(
                        'data.' . Shift::FINISH_AT . '.date_for_human',
                        $finishAt->format(Transformer::HUMAN_DATE_FORMAT)
                    )
                    ->where(
                        'data.' . Shift::FINISH_AT . '.time_short',
                        $finishAt->format(TIME_FORMAT_SHORT)
                    )
                    ->where(
                        'data.' . Shift::ORGANIZATION_BRANCH_ID,
                        $this->testingUser->getHashedKey(Shift::ORGANIZATION_BRANCH_ID)
                    )
                    ->where(
                        'data.' . Shift::ORGANIZATION_ID,
                        $this->testingUser->getHashedKey(Shift::ORGANIZATION_ID)
                    )
                    ->etc()
            );
    }

    public function testSuccessWithNullOrganizationBranchId(): void
    {
        $startAt = Carbon::now();
        $finishAt = Carbon::now()->addHours(8);

        $data = [
            Shift::START_AT => $startAt->format(DATE_TIME_FORMAT),
            Shift::FINISH_AT => $finishAt->format(DATE_TIME_FORMAT),
            Shift::EXCLUDE_ORGANIZATION_BRANCH => 1
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('data.' . Shift::ORGANIZATION_BRANCH_ID, null)
                    ->etc()
            );
    }
}
