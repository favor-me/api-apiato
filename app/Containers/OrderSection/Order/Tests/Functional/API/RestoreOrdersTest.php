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
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\Functional\ApiTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class RestoreOrdersTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/restore/' . Container::getApiUri();
    }

    public function testIsUnauthorized(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => ''
        ]);

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }

    public function testWithTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrderModel::factory()
            ->count(2)
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->response
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleRestored($models->count()))
                    ->etc()
            );
    }

    public function testWithNotTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrderModel::factory()
            ->count(2)
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ],
                    IDS . '.1' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testWithOneTrashedAndOneIsNotTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrderModel::factory()->create();

        $modelTrashed = OrderModel::factory()
            ->trashed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => [
                $model->getHashedKey(),
                $modelTrashed->getHashedKey()
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
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
}
