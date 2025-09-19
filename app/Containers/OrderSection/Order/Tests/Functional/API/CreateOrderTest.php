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

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $paymentType = Manager::getInstance()->get(CashType::class);

        $data = [
            Order::PAYMENT_TYPE => $paymentType->getName(),
            Order::CLIENT_ID => $client->getHashedKey(),
            Order::COMMENT => 'Order comment',
            Order::TOTAL => 2500
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
                    ->etc()
            );
    }
}
