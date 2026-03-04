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

namespace App\Containers\ShiftSection\Shift\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class FindShiftByIdTest extends ApiTestCase
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
        $this->getTestingOrganizationOwnerUser();

        $this
            ->injectId(555)
            ->makeCall();

        $this->assertGivenDataIsInvalid();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $model = ShiftModel::factory()->create();

        $this
            ->injectId($model->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, ShiftModel::RESOURCE_KEY)
                    ->where('data.' . ID, $model->getHashedKey())
                    ->etc()
            );
    }
}
