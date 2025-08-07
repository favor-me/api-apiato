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
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindOrganizationByIdTest extends ApiTestCase
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

        $this->assertGivenDataIsInvalid();
    }

    public function testSuccess(): void
    {
        $model = OrganizationModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationModel::RESOURCE_KEY)
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('meta.include', [
                        Organization::INCLUDE_USER_OWNER,
                        Organization::INCLUDE_USERS
                    ])
                    ->etc()
            );
    }
}
