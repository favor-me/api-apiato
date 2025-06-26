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

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Facades\Container;
use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\Fluent\AssertableJson;

class ApiLoginProxyTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/clients/web/login';

    protected array $access = [
        'permissions' => '',
        'roles' => ''
    ];

    public function testClientWebAdminProxyLogin(): void
    {
        $data = [
            'email' => 'testing@mail.com',
            'password' => 'testingpass'
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'api');

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('expires_in')
                ->has('access_token')
                ->has('refresh_token')
                ->where('token_type', 'Bearer')
        );
    }

    public function testClientWebAdminProxyUnconfirmedLogin(): void
    {
        $data = [
            'email' => 'testing2@mail.com',
            'password' => 'testingpass',
            'email_verified_at' => null
        ];

        $this->getTestingUser($data);
        $this->actingAs($this->testingUser, 'api');

        $this->makeCall($data);

        if (Container::getConfig('require_email_confirmation')) {
            $this->response->assertConflict();
        } else {
            $this->response->assertOk();
        }
    }

    public function testLoginWithNameAttribute(): void
    {
        $data = [
            'email' => 'testing@mail.com',
            'password' => 'testingpass',
            'name' => 'username'
        ];

        $this->getTestingUser($data);
        $this->actingAs($this->testingUser, 'api');

        $this->setLoginAttributes([
            'email' => [],
            'name' => []
        ]);

        $request = [
            'password' => 'testingpass',
            'name' => 'username'
        ];

        $this->makeCall($request);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('expires_in')
                ->has('access_token')
                ->has('refresh_token')
                ->where('token_type', 'Bearer')
        );
    }

    public function testGivenOnlyOneLoginAttributeIsSetThenItShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email' => []
        ]);

        $data = [
            'password' => 'so-secret'
        ];

        $this->makeCall($data);

        $this->response->assertUnprocessable();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.email', [__('validation.custom.email.required')])
                ->etc()
        );
    }

    public function testGivenMultipleLoginAttributeIsSetThenAtLeastOneShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email' => [],
            'name' => []
        ]);

        $data = [
            'password' => 'so-secret'
        ];

        $this->makeCall($data);

        $this->response->assertUnprocessable();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.email', [Container::trans('validation.email.required_without_all')])
                ->where('errors.name', ['The name field is required when none of email are present.'])
                ->etc()
        );
    }

    private function setLoginAttributes(array $attributes): void
    {
        Config::set('appSection-authentication.login.attributes', $attributes);
    }
}
