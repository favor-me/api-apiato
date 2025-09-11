<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class RestoreOrganizationUnitsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => Role::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/restore/' . Container::getApiUri();
    }

    public function testIsUnauthorized(): void
    {
        $this->getTestingUser(null, [
            ROLES => ''
        ]);

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }

    public function testWithNotOwnTrashed(): void
    {
        $models = OrganizationUnitModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->assertGivenDataIsInvalid();
    }

    public function testOwnWithTrashed(): void
    {
        $user = $this->getTestingOrganizationUser();

        $models = OrganizationUnitModel::factory()
            ->count(2)
            ->trashed()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
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

        $models = OrganizationUnitModel::factory()
            ->count(2)
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
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

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $modelTrashed = OrganizationUnitModel::factory()
            ->trashed()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
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
