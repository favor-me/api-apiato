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

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteOrganizationClientsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri() . '?' . Request::FORCE_DELETE . '=1';
    }

    public function testWithNotTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->makeCall([
            IDS => [
                $model->getHashedKey()
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

    public function testFailedWithNoExistsIds(): void
    {
        $this->getTestingOrganizationUser();

        $this->makeCall([
            IDS => [
                hash_encode(123)
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

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrganizationClientModel::factory()
            ->count(2)
            ->trashed()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id
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

    public function testCantNotOwn(): void
    {
        $this->getTestingOrganizationUser();
        $model = OrganizationClientModel::factory()->create();

        $this->makeCall([
            IDS => [
                $model->getHashedKey()
            ]
        ]);

        $this->assertGivenDataIsInvalid();
    }
}
