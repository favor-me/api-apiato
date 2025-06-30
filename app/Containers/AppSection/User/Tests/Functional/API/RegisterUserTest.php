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

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class RegisterUserTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/register';

    protected bool $auth = false;

    protected array $access = [
        ROLES => '',
        PERMISSIONS => ''
    ];

    public function testRegisterNewUserWithCredentials(): void
    {
        $this->makeCall($this->testData);

        $this->response->assertOk();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . OBJECT, 'User')
                ->where('data.' . User::EMAIL, $this->testData[User::EMAIL])
                ->where('data.' . User::NAME, $this->testData[User::NAME])
                ->etc()
        );

        $this->assertDatabaseHas('users', [User::EMAIL => $this->testData[User::EMAIL]]);
    }

    public function testRegisterNewUserUsingGetVerb(): void
    {
        $this
            ->endpoint('get@v1/register')
            ->makeCall($this->testData);

        $this->response->assertMethodNotAllowed();
    }

    public function testRegisterExistingUser(): void
    {
        $this->getTestingUser($this->testData);

        $data = [
            User::EMAIL => $this->testData[User::EMAIL],
            User::NAME => $this->testData[User::NAME],
            User::PASSWORD => $this->testData[User::PASSWORD]
        ];

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::EMAIL, [__('validation.custom.email.unique')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithoutEmail(): void
    {
        $data = $this->testData;
        unset($data[User::EMAIL]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::EMAIL, [__('validation.custom.email.required')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithoutName(): void
    {
        $data = $this->testData;
        unset($data[User::NAME]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::NAME, [__('validation.custom.name.required')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithoutPassword(): void
    {
        $data = $this->testData;
        unset($data[User::PASSWORD]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::PASSWORD, [__('validation.custom.password.required')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $data = $this->testData;
        $data[User::EMAIL] = 'test.mail.ru';

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::EMAIL, [__('validation.custom.email.email')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidSurname(): void
    {
        $data = $this->testData;
        unset($data[User::SURNAME]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::SURNAME, [__('validation.custom.surname.required')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidPatronymic(): void
    {
        $data = $this->testData;
        unset($data[User::PATRONYMIC]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::PATRONYMIC, [__('validation.custom.patronymic.required')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidGender(): void
    {
        $data = $this->testData;
        $data[User::GENDER] = 'false';

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::GENDER, [__('validation.custom.gender.boolean')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidBirth(): void
    {
        $data = $this->testData;
        $data[User::BIRTH] = '12.222.21440';

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::BIRTH, [__('validation.custom.birth.date')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithInvalidRole(): void
    {
        $data = $this->testData;
        $data['role'] = 'tester';

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.role', [__('validation.custom.role.exists')])
                ->etc()
        );
    }

    public function testRegisterNewUserWithNoRequiredData(): void
    {
        $address = 'Test address';

        $data = array_merge($this->testData, [
            User::GENDER => true,
            User::LOGIN => 'test-login',
            User::BIRTH => '12.11.2022',
            'role' => Role::ORGANIZATION_OWNER,
            'address' => $address
        ]);

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . User::LOGIN, $data[User::LOGIN])
                ->where('data.' . User::EMAIL, $this->testData[User::EMAIL])
                ->where('data.' . User::NAME, $this->testData[User::NAME])
                ->where('data.' . User::PATRONYMIC, $this->testData[User::PATRONYMIC])
                ->where('data.' . User::SURNAME, $this->testData[User::SURNAME])
                ->where('data.' . User::GENDER, $data[User::GENDER])
                ->where('data.' . User::BIRTH, strtotime($data[User::BIRTH]))
                ->etc()
        );


        $responseContent = $this->getResponseContentObject();

        $user = UserModel::findOrFail($this->decodeHashValue($responseContent->data->id));

        $this->assertTrue($user->hasRole(Role::ORGANIZATION_OWNER));
        $this->assertSame($address, $responseContent->data->profile->data->address);

        $this->assertDatabaseHas(UserModel::TABLE, [User::EMAIL => $this->testData[User::EMAIL]]);

        $this->assertSame($data[User::LOGIN], $user->login);
        $this->assertSame($address, $user->profile->address);
    }

    public function testRegisterNewUserWithExistsLogin(): void
    {
        $user = UserModel::factory()->create();

        $data = array_merge($this->testData, [
            User::LOGIN => $user->login,
            'role' => Role::ORGANIZATION_OWNER
        ]);

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . User::LOGIN, [Container::trans('validation.login.unique')])
                ->etc()
        );
    }
}
