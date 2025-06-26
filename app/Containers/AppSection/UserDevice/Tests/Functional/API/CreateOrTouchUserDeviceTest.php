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

namespace App\Containers\AppSection\UserDevice\Tests\Functional\API;

use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Facades\Container;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Tests\Functional\ApiUnitTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOrTouchUserDeviceTest extends ApiUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testUserIsNotOwner(): void
    {
        $user = User::factory()->create();

        $this
            ->injectId($user->id)
            ->makeCall([
                BaseUserDevice::MODEL => 'Motorola E396',
                BaseUserDevice::TOKEN => 'token...'
            ]);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccessCreate(): void
    {
        $this->getTestingUser();

        $this
            ->injectId($this->testingUser->id)
            ->makeCall([
                BaseUserDevice::MODEL => 'Motorola E396',
                BaseUserDevice::TOKEN => 'token...'
            ]);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . OBJECT, UserDevice::RESOURCE_KEY)
                ->where('data.' . BaseUser::ID, $this->testingUser->getHashedKey())
                ->where('data.' . BaseUserDevice::MODEL, 'Motorola E396')
                ->where('data.' . BaseUserDevice::TOKEN, 'token...')
                ->etc()
        );
    }

    public function testSuccessUpdate(): void
    {
        $this->getTestingUser();

        $userDevice = UserDevice::factory()
            ->user($this->testingUser)
            ->create();

        $this
            ->injectId($userDevice->user_id)
            ->makeCall([
                BaseUserDevice::MODEL => $userDevice->model,
                BaseUserDevice::TOKEN => 'new token...'
            ]);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . BaseUser::ID, $this->testingUser->getHashedKey())
                ->where('data.' . BaseUserDevice::MODEL, $userDevice->model)
                ->where('data.' . BaseUserDevice::TOKEN, 'new token...')
                ->etc()
        );
    }
}
