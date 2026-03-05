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
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteItemsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri();
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $this->makeCall([
            IDS => [
                hash_encode(123)
            ]
        ]);

        $this
            ->assertGivenDataIsInvalid()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors', [
                        IDS . '.0' => [
                            __('validation.custom.ids.*.exists')
                        ]
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

        $models = ItemModel::factory()
            ->count(2)
            ->create([
                Item::ORDER_ID => $order->id,
                Item::SHIFT_ID => $shift->id
            ]);

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleDeleted($models->count()))
                    ->etc()
            );
    }
}
