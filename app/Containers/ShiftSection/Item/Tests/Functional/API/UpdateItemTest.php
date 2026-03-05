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

namespace App\Containers\ShiftSection\Item\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\ShiftSection\Item\Facades\Container;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Item\Tests\Functional\ApiTestCase;
use App\Containers\ShiftSection\ItemType\AwardType;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateItemTest extends ApiTestCase
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
                    ->where(MESSAGE, __('ship::exception.message.empty_update_data'))
                    ->etc()
            );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $data = [
            Item::VALUE => 100
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.ids.*.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $shift = ShiftModel::factory()->create();

        $order = OrderModel::factory()
            ->shift($shift)
            ->organization($this->testingUser->organization_id)
            ->create();

        $model = ItemModel::factory()
            ->create([
                Item::ORDER_ID => $order->id,
                Item::SHIFT_ID => $shift->id
            ]);

        $type = Manager::getInstance()->get(AwardType::class);

        $data = [
            Item::VALUE => 400,
            Item::TYPE => $type->getName()
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
                    ->where('data.' . Item::TYPE . '.name', $data[Item::TYPE])
                    ->where('data.' . Item::VALUE . '.currency.value', $data[Item::VALUE])
                    ->etc()
            );
    }
}
