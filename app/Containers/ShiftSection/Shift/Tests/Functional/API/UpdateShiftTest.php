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

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\Functional\ApiTestCase;
use App\Ship\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateShiftTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testWithEmptyData(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $this
            ->injectId(416346)
            ->makeCall();

        $this->response
            ->assertUnprocessable()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.empty_update_data'))
                    ->etc()
            );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $data = [
            Shift::FINISH_AT => 'now'
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $startAt = Carbon::now();
        $finishAt = Carbon::now()->addHours(8);

        $this->getTestingOrganizationOwnerUser();

        $model = ShiftModel::factory()->create();

        $data = [
            Shift::START_AT => $startAt->format(DATE_TIME_FORMAT),
            Shift::FINISH_AT => $finishAt->format(DATE_TIME_FORMAT)
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where(
                        'data.' . Shift::START_AT . '.date_for_human',
                        $startAt->format(DATE_FORMAT)
                    )
                    ->where(
                        'data.' . Shift::START_AT . '.time_short',
                        $startAt->format(TIME_FORMAT_SHORT)
                    )
                    ->where(
                        'data.' . Shift::FINISH_AT . '.date_for_human',
                        $finishAt->format(DATE_FORMAT)
                    )
                    ->where(
                        'data.' . Shift::FINISH_AT . '.time_short',
                        $finishAt->format(TIME_FORMAT_SHORT)
                    )
                    ->where(
                        'data.' . Shift::ORGANIZATION_BRANCH_ID,
                        $this->testingUser->getHashedKey(Shift::ORGANIZATION_BRANCH_ID)
                    )
                    ->etc()
            );
    }

    public function testSuccessConfirm(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $model = ShiftModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall([
                CONFIRMED => 1
            ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where(
                        'data.' . Shift::CONFIRMED_BY,
                        $this->testingUser->getHashedKey()
                    )
                    ->where(
                        'data.' . Shift::CONFIRMED_AT . '.date_for_human',
                        now()->utc()->format(DATE_FORMAT)
                    )
                    ->etc()
            );
    }

    public function testSuccessPayment(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $model = ShiftModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall([
                Shift::PAYMENT => 1
            ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where(
                        'data.' . Shift::PAYMENT_AT . '.date_for_human',
                        now()->utc()->format(DATE_FORMAT)
                    )
                    ->etc()
            );
    }
}
