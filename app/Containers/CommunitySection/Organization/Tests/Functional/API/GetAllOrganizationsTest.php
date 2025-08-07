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

namespace App\Containers\CommunitySection\Organization\Tests\Functional\API;

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Ship\Requests\ApiRequest;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrganizationsTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::READ
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testSuccess(): void
    {
        $baseCount = OrganizationModel::count();

        $models = OrganizationModel::factory()
            ->count(3)
            ->create();

        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('meta.pagination.total', $models->count() + $baseCount)
                    ->etc()
            );
    }

    public function testOnlyTrashed(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => Permissions::READ_ARCHIVE
        ]);

        OrganizationModel::factory()
            ->count(3)
            ->create();

        $trashedModels = OrganizationModel::factory()
            ->trashed()
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', 1)
                    ->where('data.0.' . ID, $trashedModels->getHashedKey())
                    ->etc()
            );
    }

    public function testCanReadOnlyTrashedList(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => [
                Permissions::READ,
                Permissions::READ_ARCHIVE
            ]
        ]);

        $trashedModels = OrganizationModel::factory()
            ->count(3)
            ->trashed()
            ->create();

        OrganizationModel::factory()
            ->count(2)
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $trashedModels->count())
                    ->etc()
            );
    }

    public function testCantReadOnlyTrashedList(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => [
                Permissions::READ
            ]
        ]);

        $baseCount = OrganizationModel::count();

        OrganizationModel::factory()
            ->count(5)
            ->trashed()
            ->create();

        $models = OrganizationModel::factory()
            ->count(6)
            ->create();

        $this
            ->endpoint($this->endpoint . '?' . Request::ONLY_TRASHED . '=1')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $baseCount + $models->count())
                    ->etc()
            );
    }

    public function testToList(): void
    {
        $defaultCount = OrganizationModel::count();

        $models = OrganizationModel::factory()
            ->count(3)
            ->create();

        $this
            ->endpoint($this->endpoint . '?to=' . ApiRequest::TO_LIST_VALUE)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('meta.pagination.total', $defaultCount + $models->count())
                    ->where('data', function (Collection $statuses) {
                        $statuses->each(function ($status) {
                            $this->assertSame([
                                'value',
                                'title'
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
