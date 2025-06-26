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

use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetAuthenticatedUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/user/profile';

    public function test(): void
    {
        $this->getTestingUser();

        $this->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . OBJECT, 'User')
                ->where('data.' . ID, $this->testingUser->getHashedKey())
                ->etc()
        );
    }
}
