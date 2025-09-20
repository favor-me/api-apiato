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

namespace App\Containers\OrderSection\Order\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\Functional\ApiTestCase;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\PaymentType\Manager;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOrderTest extends ApiTestCase
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
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testWithoutAccess(): void
    {
        $this->getTestingOrganizationUser(null, [
            ROLES => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testIsNotOrganizationUser(): void
    {
        $this->makeCall($this->testData);
        $this->assertActionIsUnauthorized();
    }

    public function testWithNotOrganizationClient(): void
    {
        $this->getTestingOrganizationUser();

        $client = OrganizationClientModel::factory()->create();

        $data = [
            Order::CLIENT_ID => $client->getHashedKey()
        ];

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . Order::CLIENT_ID, [
                    Container::trans('validation.client_id.exists')
                ])
                ->etc()
        );
    }

    public function testInvalidTotal(): void
    {
        $user = $this->getTestingOrganizationUser();

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $paymentType = Manager::getInstance()->get(CashType::class);

        $unitA = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => app('money')->addCurrency(200)->val(),
                OrganizationUnit::CLIENT_PRICE => app('money')->addCurrency(250)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $amount = 2;

        $data = [
            Order::PAYMENT_TYPE => $paymentType->getName(),
            Order::CLIENT_ID => $client->getHashedKey(),
            Order::COMMENT => 'Order comment',
            Order::TOTAL => 600,
            Order::ITEMS => [
                [
                    Item::NAME => $unitA->name,
                    Item::UNIT_ID => $unitA->id,
                    Item::SKU => $unitA->sku,
                    Item::COST_PRICE => $unitA->cost_price->currency()->val(),
                    Item::CLIENT_PRICE => $unitA->client_price->currency()->val(),
                    Item::AMOUNT => $amount
                ]
            ]
        ];

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors.' . Order::TOTAL, [
                        Container::trans('validation.total.size', [
                            'size' => $unitA->client_price
                                ->currency()
                                ->multiply($amount)
                                ->text()
                        ])
                    ])
                    ->etc()
            );
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $paymentType = Manager::getInstance()->get(CashType::class);

        $unitA = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => app('money')->addCurrency(100)->val(),
                OrganizationUnit::CLIENT_PRICE => app('money')->addCurrency(210)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $unitB = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::COST_PRICE => app('money')->addCurrency(120)->val(),
                OrganizationUnit::CLIENT_PRICE => app('money')->addCurrency(150)->val(),
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $data = [
            Order::PAYMENT_TYPE => $paymentType->getName(),
            Order::CLIENT_ID => $client->getHashedKey(),
            Order::COMMENT => 'Order comment',
            Order::TOTAL => (210 * 2) + 150,
            Order::ITEMS => [
                [
                    Item::NAME => $unitA->name,
                    Item::UNIT_ID => $unitA->id,
                    Item::SKU => $unitA->sku,
                    Item::COST_PRICE => $unitA->cost_price->currency()->val(),
                    Item::CLIENT_PRICE => $unitA->client_price->currency()->val(),
                    Item::AMOUNT => 2
                ],
                [
                    Item::NAME => $unitB->name,
                    Item::UNIT_ID => $unitB->id,
                    Item::SKU => $unitB->sku,
                    Item::COST_PRICE => $unitB->cost_price->currency()->val(),
                    Item::CLIENT_PRICE => $unitB->client_price->currency()->val(),
                    Item::AMOUNT => 1
                ]
            ]
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrderModel::RESOURCE_KEY)
                    ->where('data.' . Order::PAYMENT_TYPE, $data[Order::PAYMENT_TYPE])
                    ->where('data.' . Order::CLIENT_ID, $data[Order::CLIENT_ID])
                    ->where('data.' . Order::COMMENT, $data[Order::COMMENT])
                    ->where('data.' . Order::TOTAL . '.currency.value', $data[Order::TOTAL])
                    ->has('data.' . Order::ITEMS . '.data', count($data[Order::ITEMS]))

                    // Check unitA
                    ->where('data.' . Order::ITEMS . '.data.0.' . Item::NAME, $unitA->name)
                    ->where('data.' . Order::ITEMS . '.data.0.' . Item::UNIT_ID, $unitA->getHashedKey())
                    ->where('data.' . Order::ITEMS . '.data.0.' . Item::SKU, $unitA->sku)
                    ->where(
                        'data.' . Order::ITEMS . '.data.0.' . Item::COST_PRICE . '.currency.value',
                        (int)$unitA->cost_price->currency()->val()
                    )
                    ->where(
                        'data.' . Order::ITEMS . '.data.0.' . Item::CLIENT_PRICE . '.currency.value',
                        (int)$unitA->client_price->currency()->val()
                    )
                    ->where('data.' . Order::ITEMS . '.data.0.' . Item::AMOUNT, $data[Order::ITEMS][0][Item::AMOUNT])

                    // Check unitB
                    ->where('data.' . Order::ITEMS . '.data.1.' . Item::NAME, $unitB->name)
                    ->where('data.' . Order::ITEMS . '.data.1.' . Item::UNIT_ID, $unitB->getHashedKey())
                    ->where('data.' . Order::ITEMS . '.data.1.' . Item::SKU, $unitB->sku)
                    ->where(
                        'data.' . Order::ITEMS . '.data.1.' . Item::COST_PRICE . '.currency.value',
                        (int)$unitB->cost_price->currency()->val()
                    )
                    ->where(
                        'data.' . Order::ITEMS . '.data.1.' . Item::CLIENT_PRICE . '.currency.value',
                        (int)$unitB->client_price->currency()->val()
                    )
                    ->where('data.' . Order::ITEMS . '.data.1.' . Item::AMOUNT, $data[Order::ITEMS][1][Item::AMOUNT])
                    ->etc()
            );
    }
}
