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

use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

class ApiRefreshProxyTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/clients/web/refresh';

    protected array $access = [
        'permissions' => '',
        'roles' => ''
    ];

    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'email' => 'testing@mail.com',
            'password' => 'testing_pass'
        ];

        $this->getTestingUser($this->data);
        $this->actingAs($this->testingUser, 'web');
    }

    public function testRequestingRefreshTokenWithoutPassingARefreshTokenShouldThrowAnException(): void
    {
        $data = [
            'refresh_token' => null
        ];

        $this->makeCall($data);

        $this->response->assertBadRequest();

        $message = (new RefreshTokenMissedException())->getMessage();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has(MESSAGE)
                ->where(MESSAGE, $message)
                ->etc()
        );
    }

    public function testOnSuccessfulRefreshTokenRequestEnsureValuesAreSetProperly(): void
    {
        $this
            ->endpoint('post@v1/clients/web/login')
            ->makeCall($this->data);

        $data = [
            'refresh_token' => $this->getResponseContentObject()->refresh_token
        ];

        $this
            ->endpoint($this->endpoint)
            ->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('expires_in')
                ->has('access_token')
                ->has('refresh_token')
                ->where('token_type', 'Bearer')
        );
    }
}
