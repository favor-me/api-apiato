<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class PlusOrganizationUnitBalanceTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}/plus-balance');
    }

    public function testNotInfinity(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::BALANCE => 4,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $addBalance = 10;

        $this
            ->injectId($model->id)
            ->makeCall([
                OrganizationUnit::BALANCE => $addBalance
            ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . OrganizationUnit::BALANCE, (int)$model->balance + $addBalance)
                    ->etc()
            );
    }

    public function testInfinity(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::BALANCE => 4,
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $this
            ->injectId($model->id)
            ->makeCall([
                OrganizationUnit::IS_INFINITY_BALANCE => 1
            ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . OrganizationUnit::BALANCE, ZERO)
                    ->where('data.' . OrganizationUnit::IS_INFINITY_BALANCE, true)
                    ->etc()
            );
    }
}
