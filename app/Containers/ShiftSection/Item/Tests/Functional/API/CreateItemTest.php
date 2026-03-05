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
use App\Containers\ShiftSection\ItemType\IncomeType;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateItemTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testWithoutAccess(): void
    {
        $this->getTestingUser(null, [
            ROLES => '',
            PERMISSIONS => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $shift = ShiftModel::factory()->create();

        $order = OrderModel::factory()
            ->shift($shift)
            ->organization($this->testingUser->organization_id)
            ->create();

        $type = Manager::getInstance()->get(IncomeType::class);

        $data = [
            Item::SHIFT_ID => $shift->getHashedKey(),
            Item::ORDER_ID => $order->getHashedKey(),
            Item::TYPE => $type->getName(),
            Item::VALUE => 150
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, ItemModel::RESOURCE_KEY)
                    ->where('data.' . Item::SHIFT_ID, $data[Item::SHIFT_ID])
                    ->where('data.' . Item::ORDER_ID, $data[Item::ORDER_ID])
                    ->where('data.' . Item::TYPE . '.name', $data[Item::TYPE])
                    ->where('data.' . Item::VALUE . '.currency.value', $data[Item::VALUE])
                    ->where('data.' . CREATED_BY, $this->testingUser->getHashedKey())
                    ->etc()
            );
    }
}
