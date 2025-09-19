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
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateOrganizationUnitTest extends ApiTestCase
{
    protected array $access = [
        ROLES => Role::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testWithEmptyData(): void
    {
        $this->getTestingOrganizationUser();

        $this
            ->injectId(416346)
            ->makeCall();

        $this->response
            ->assertUnprocessable()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.message.empty_update_data'))
                    ->etc()
            );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationUser();

        $data = [
            OrganizationUnit::NAME => 'New name'
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testNotOwn(): void
    {
        $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()->create();

        $data = [
            OrganizationUnit::NAME => 'My unit'
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $user->organization_id
            ]);

        $data = [
            OrganizationUnit::NAME => 'My unit'
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . OrganizationUnit::NAME, $data[OrganizationUnit::NAME])
                    ->etc()
            );
    }
}
