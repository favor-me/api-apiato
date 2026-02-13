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

namespace App\Containers\OrganizationSection\Shift\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\OrganizationSection\Shift\Facades\Container;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteShiftsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri() . '?' . Request::FORCE_DELETE . '=1';
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->getTestingOrganizationOwnerUser();

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
        $this->getTestingOrganizationOwnerUser();

        $organizationUser = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $models = ShiftModel::factory()
            ->count(2)
            ->create([
                CREATED_BY => $organizationUser->id,
                Shift::ORGANIZATION_ID => $this->testingUser->organization_id
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
}
