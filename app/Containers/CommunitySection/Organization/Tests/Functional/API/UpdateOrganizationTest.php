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

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateOrganizationTest extends ApiTestCase
{
    protected array $testData = [
        Organization::NAME => 'New name',
        Organization::INN => 22334455,
        Organization::EMAIL => 'email@test.ru',
        Organization::PHONE_NUMBER => 79271110011
    ];

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testSuccessOwn(): void
    {
        $ownerUser = $this->getTestingUser();

        $organization = OrganizationModel::factory()
            ->create([
                Organization::USER_OWNER_ID => $ownerUser->id
            ]);

        $ownerUser->update([
            User::ORGANIZATION_ID => $organization->id,
            User::IS_ORGANIZATION_OWNER => true
        ]);

        $this
            ->injectId($ownerUser->organization_id)
            ->makeCall($this->testData);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $organization->getHashedKey())
                    ->where('data.' . Organization::NAME, $this->testData[Organization::NAME])
                    ->where('data.' . Organization::INN, $this->testData[Organization::INN])
                    ->where('data.' . Organization::EMAIL, $this->testData[Organization::EMAIL])
                    ->where('data.' . Organization::PHONE_NUMBER, $this->testData[Organization::PHONE_NUMBER])
                    ->where('data.' . Organization::USER_OWNER_ID, $ownerUser->getHashedKey())
                    ->etc()
            );
    }

    public function testIsInOrganizationAndNotOwner(): void
    {
        $user = $this->getTestingUser();

        $organization = OrganizationModel::factory()
            ->create([
                Organization::USER_OWNER_ID => $user->id
            ]);

        $user->update([
            User::ORGANIZATION_ID => $organization->id
        ]);

        $this
            ->injectId($organization->id)
            ->makeCall($this->testData);

        $this->response
            ->assertForbidden()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.unauthorized_action'))
                    ->etc()
            );
    }

    public function testIsNotOwner(): void
    {
        $this->makeCall($this->testData);

        $this->response
            ->assertForbidden()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.unauthorized_action'))
                    ->etc()
            );
    }
}
