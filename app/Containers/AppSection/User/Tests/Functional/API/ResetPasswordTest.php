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

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Tasks\CreatePasswordResetTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;

class ResetPasswordTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/password/reset';

    public function testWithEmptyData(): void
    {
        $this->makeCall();

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.token', [Container::trans('validation.token.required')])
                ->where('errors.email', [__('validation.custom.email.required')])
                ->where('errors.password', [__('validation.custom.password.required')])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingUser([
            'password' => 111111
        ]);

        $oldPassword = $user->password;

        //  Generate token.
        $token = app(CreatePasswordResetTask::class)->run($user);

        $newPassword = '555444';

        $this->makeCall([
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword
        ]);

        $this->response->assertOk();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has(MESSAGE)
                ->where(MESSAGE, __('passwords.reset'))
                ->etc()
        );

        $user->refresh();
        $this->assertNotSame($oldPassword, $user->password);
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}
