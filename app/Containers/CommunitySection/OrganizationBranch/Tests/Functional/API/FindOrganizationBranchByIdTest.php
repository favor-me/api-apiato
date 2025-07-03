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

namespace App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\API;

use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindOrganizationBranchByIdTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testSuccess(): void
    {
        $model = OrganizationBranchModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationBranchModel::RESOURCE_KEY)
                    ->where('data.' . ID, $model->getHashedKey())
                    ->etc()
            );
    }
}
