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

namespace App\Containers\OrderSection\Order\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Actions\CreateOrderAction;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\PaymentType\Manager;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class CreateOrderActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $unitA = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::COST_PRICE => 100,
                UnitPrice::CLIENT_PRICE => 210,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitB = OrganizationUnitModel::factory()
            ->create([
                UnitPrice::COST_PRICE => 120,
                UnitPrice::CLIENT_PRICE => 150,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $paymentType = Manager::getInstance()->get(CashType::class);
        $customClientPrice = 300.0;

        $data = [
            Order::ORGANIZATION_ID => $user->organization_id,
            Order::PAYMENT_TYPE => $paymentType->getName(),
            Order::CLIENT_ID => $client->id,
            Order::COMMENT => 'Order comment',
            Order::TOTAL => 3500,
            Order::ITEMS => [
                [
                    Item::NAME => $unitA->name,
                    Item::UNIT_ID => $unitA->id,
                    Item::SKU => $unitA->sku,
                    Item::COST_PRICE => $unitA->cost_price->val(),
                    Item::CLIENT_PRICE => $customClientPrice,
                    Item::AMOUNT => 2
                ],
                [
                    Item::NAME => $unitB->name,
                    Item::UNIT_ID => $unitB->id,
                    Item::SKU => $unitB->sku,
                    Item::COST_PRICE => $unitB->cost_price->val(),
                    Item::CLIENT_PRICE => $unitB->client_price->val(),
                    Item::AMOUNT => 1
                ]
            ]
        ];

        $dto = new CreateOrderDto($data);

        $result = app(CreateOrderAction::class)->run($dto);

        /** @var ItemModel $customPriceItem */
        $customPriceItem = $result->items
            ->first(
                fn (ItemModel $item) => $item->unit_id === $unitA->id
            );

        $this->assertSame($unitA->client_price->val(), $customPriceItem->unit_client_price->val());
        $this->assertSame($customClientPrice, $customPriceItem->client_price->val());

        $this->assertInstanceOf(OrderModel::class, $result);

        // 300 + 300 + 150
        $this->assertSame(750.0, $result->total->val());

        // ((300 - 100) * 2) + (150 - 120)
        $this->assertSame(430.0, $result->profit->val());
    }
}
