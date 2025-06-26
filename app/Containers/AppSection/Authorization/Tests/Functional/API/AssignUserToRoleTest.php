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

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class AssignUserToRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/assign?include=roles';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-admins-access'
    ];

    public function testAssignUserToRole(): void
    {
        $randomUser = User::factory()->create();
        $role = Role::factory()->create();

        $data = [
            'roles_ids' => [
                $role->getHashedKey()
            ],
            'user_id' => $randomUser->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.id', $data['user_id'])
                ->where('data.roles.data.0.id', $data['roles_ids'][0])
                ->etc()
        );
    }

    public function testAssignUserToManyRoles(): void
    {
        $user = User::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();

        $data = [
            'roles_ids' => [
                $role1->getHashedKey(),
                $role2->getHashedKey()
            ],
            'user_id' => $user->getHashedKey()
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.id', $data['user_id'])
                ->has('data.roles.data', count($data['roles_ids']))
                ->where('data.roles.data.0.id', $role1->getHashedKey())
                ->where('data.roles.data.1.id', $role2->getHashedKey())
                ->etc()
        );
    }
}
