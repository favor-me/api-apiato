<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateUserTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testUpdateExistingUser(): void
    {
        $user = $this->getTestingUser([
            User::PHONE_NUMBER => 79272221100
        ]);

        $data = [
            User::NAME => 'Updated name',
            User::EMAIL => $user->email,
            User::LOGIN => $user->login,
            User::PHONE_NUMBER => $user->phone_number,
            User::PATRONYMIC => 'Updated patronymic',
            User::SURNAME => 'Updated surname',
            User::GENDER => false,
            User::BIRTH => '2015-10-15'
        ];

        $this
            ->injectId($user->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, 'User')
                    ->where('data.' . User::EMAIL, $user->email)
                    ->where('data.' . User::NAME, $data[User::NAME])
                    ->where('data.' . User::PHONE_NUMBER, $user->phone_number)
                    ->where('data.' . User::PATRONYMIC, $data[User::PATRONYMIC])
                    ->where('data.' . User::GENDER, $data[User::GENDER])
                    ->where('data.' . User::LOGIN, $user->login)
                    ->etc()
            );

        $this->assertDatabaseHas(UserModel::TABLE, [User::NAME => $data[User::NAME]]);
    }

    public function testUpdateExistingUserButNotHavePermissions(): void
    {
        $this->access = [
            ROLES => '',
            PERMISSIONS => ''
        ];

        $user = UserModel::factory()->create();

        $data = [
            User::NAME => 'Updated name',
            User::PATRONYMIC => 'Updated patronymic',
            User::SURNAME => 'Updated surname',
            User::GENDER => false,
            User::BIRTH => '2015-10-15'
        ];

        $this
            ->injectId($user->id)
            ->makeCall($data);

        $this->assertActionIsUnauthorized();
    }

    public function testUserCantUpdateOtherUser(): void
    {
        $user = UserModel::factory()->create();

        $data = [
            User::NAME => 'Updated Name'
        ];

        $this
            ->injectId($user->id)
            ->makeCall($data);

        $this->response
            ->assertForbidden()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('message')
                    ->where('message', __('ship::exception.unauthorized_action'))
                    ->etc()
            );
    }

    public function testUpdateWithoutData(): void
    {
        $user = $this->getTestingUser();

        $this
            ->injectId($user->id)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $user->getHashedKey())
                    ->etc()
            );
    }

    public function testUpdateExistingUserWithEmptyValues(): void
    {
        $this->getTestingUser();

        $data = [
            User::NAME => '',
            User::PATRONYMIC => '',
            User::SURNAME => '',
            User::GENDER => '',
            User::BIRTH => ''
        ];

        $this
            ->injectId($this->testingUser->id)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where(
                    'errors.' . User::NAME,
                    [Container::trans('validation.name.min', ['min' => User::NAME_MIN_LENGTH])]
                )
                ->where(
                    'errors.' . User::SURNAME,
                    [Container::trans('validation.surname.min', ['min' => User::NAME_MIN_LENGTH])]
                )
                ->where(
                    'errors.' . User::PATRONYMIC,
                    [Container::trans('validation.patronymic.min', ['min' => User::NAME_MIN_LENGTH])]
                )
                ->etc()
        );
    }

    public function testOrganizationOwnerCanUpdateOwnUser(): void
    {
        $organization = OrganizationModel::factory()->create();

        $this->testingUser = $organization->userOwner;

        $this->testingUser
            ->assignRole(RoleModel::ORGANIZATION_OWNER);

        $this->testingUser
            ->setAttribute(User::ORGANIZATION_ID, $organization->id)
            ->setAttribute(User::IS_ORGANIZATION_OWNER, true)
            ->save();

        $ownUser = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $organization->id
            ])
            ->assignRole(RoleModel::ORGANIZATION_WORKER);

        $data = [
            User::NAME => 'New worker'
        ];

        $this
            ->injectId($ownUser->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $ownUser->getHashedKey())
                    ->where('data.' . User::NAME, $data[User::NAME])
                    ->etc()
            );
    }
}
