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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateAdminTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/admins';

    protected array $access = [
        PERMISSIONS => 'create-admins',
        ROLES => ''
    ];

    public function testCreateAdmin(): void
    {
        $this->makeCall($this->testData);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->has('data.' . ID)
                ->where('data.' . User::EMAIL, $this->testData[User::EMAIL])
                ->where('data.' . User::NAME, $this->testData[User::NAME])
                ->where('data.' . User::PATRONYMIC, $this->testData[User::PATRONYMIC])
                ->where('data.' . User::SURNAME, $this->testData[User::SURNAME])
                ->etc()
        );

        $this->assertDatabaseHas(UserModel::TABLE, [User::EMAIL => $this->testData[User::EMAIL]]);

        /** @var UserModel $user */
        $user = UserModel::where([User::EMAIL => $this->testData[User::EMAIL]])->first();
        $this->assertEquals(true, $user->is_admin);
    }
}
