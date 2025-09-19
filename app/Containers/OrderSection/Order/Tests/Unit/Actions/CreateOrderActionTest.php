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
use App\Containers\OrderSection\Order\Actions\CreateOrderAction;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\PaymentType\Manager;

final class CreateOrderActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $unitA = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => 100,
                OrganizationUnit::CLIENT_PRICE => 210,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitB = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => 120,
                OrganizationUnit::CLIENT_PRICE => 150,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $paymentType = Manager::getInstance()->get(CashType::class);

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
                    Item::CLIENT_PRICE => $unitA->client_price->val(),
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

        $this->assertInstanceOf(OrderModel::class, $result);

        // 210 + 210 + 150
        $this->assertSame(570.0, $result->total->val());

        // ((210 - 100) * 2) + (150 -120)
        $this->assertSame(250.0, $result->profit->val());
    }
}
