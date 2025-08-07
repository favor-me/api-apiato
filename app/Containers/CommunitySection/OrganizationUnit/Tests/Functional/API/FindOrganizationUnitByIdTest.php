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

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use App\Containers\CommunitySection\OrganizationUnit\Permissions\Permissions;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindOrganizationUnitByIdTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::READ
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testNotFind(): void
    {
        $this
            ->injectId(555)
            ->makeCall();

        $this->assertGivenDataWasInvalid();
    }

    public function testSuccess(): void
    {
        $model = OrganizationUnitModel::factory()->create();

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
