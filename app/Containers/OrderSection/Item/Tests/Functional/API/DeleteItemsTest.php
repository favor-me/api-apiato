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

namespace App\Containers\OrderSection\Item\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Item\Facades\Container;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Item\Tests\Functional\ApiTestCase;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteItemsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER,
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri('{' . Item::ORDER_ID . '}');
    }

    public function testNotOwn(): void
    {
        $this->getTestingOrganizationUser();

        $model = ItemModel::factory()->create();

        $this
            ->injectId($model->order_id)
            ->makeCall([
                IDS => [
                    $model->getHashedKey()
                ]
            ]);

        $this->assertGivenDataIsInvalid();
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $models = ItemModel::factory()
            ->count(2)
            ->organization($user->organization_id)
            ->order($order)
            ->create();

        $this
            ->injectId($order->id)
            ->makeCall([
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

    public function injectId($id, bool $skipEncoding = false, string $replace = '{' . Item::ORDER_ID . '}'): static
    {
        return parent::injectId($id, $skipEncoding, $replace);
    }
}
