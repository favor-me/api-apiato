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

use App\Containers\AppSection\Profile\Models\Profile;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

class UpdateUserTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/users/{id}';

    protected array $access = [
        ROLES => '',
        PERMISSIONS => 'update-users'
    ];

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

        $this->response->assertOk();

        $this->response->assertJson(
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

    public function testUpdateNonExistingUser(): void
    {
        $data = [
            User::NAME => 'Updated Name'
        ];

        $this
            ->injectId(7777)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [__('validation.custom.id.exists')])
                ->etc()
        );
    }

    public function testUpdateExistingUserWithoutData(): void
    {
        $user = UserModel::factory()->create();

        $this
            ->injectId($user->id)
            ->makeCall();

        $this->response->assertStatus(Response::HTTP_EXPECTATION_FAILED);

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has(MESSAGE)
                ->where(MESSAGE, __('ship::exception.inputs_empty'))
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

    public function testUpdateWithProfileData(): void
    {
        $profile = Profile::factory()
            ->create([
                'about_me' => 'About me text'
            ]);

        $this
            ->injectId($profile->user->id)
            ->makeCall([
                User::LOGIN => 'new-test-login',
                'about_me' => '<p>Empty</p>'
            ]);

        $this->response->assertOk();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.profile.data.about_me', 'Empty')
                ->where('data.' . User::LOGIN, 'new-test-login')
                ->etc()
        );
    }
}
