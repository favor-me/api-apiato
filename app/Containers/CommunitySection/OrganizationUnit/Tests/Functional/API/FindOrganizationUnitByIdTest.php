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

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindOrganizationUnitByIdTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testNotFind(): void
    {
        $this->getTestingOrganizationUser();

        $this
            ->injectId(555)
            ->makeCall();

        $this->assertGivenDataIsInvalid();
    }

    public function testNotOwn(): void
    {
        $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall();

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    ID => [
                        __('validation.custom.id.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testOwn(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $this
            ->injectId($model->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationUnitModel::RESOURCE_KEY)
                    ->where('data.' . ID, $model->getHashedKey())
                    ->etc()
            );
    }
}
