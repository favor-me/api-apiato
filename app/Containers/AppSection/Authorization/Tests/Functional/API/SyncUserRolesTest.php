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
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;

class SyncUserRolesTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/sync?include=roles';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-admins-access'
    ];

    public function testSyncMultipleRolesOnUser(): void
    {
        $role1 = Role::factory()
            ->create([
                'display_name' => '111'
            ]);

        $role2 = Role::factory()
            ->create([
                'display_name' => '222'
            ]);

        $randomUser = User::factory()->create();
        $randomUser->assignRole($role1);

        $data = [
            'roles_ids' => [
                $role1->getHashedKey(),
                $role2->getHashedKey(),
            ],
            'user_id' => $randomUser->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->has('data.roles.data', count($data['roles_ids']))
                ->where('data.roles.data.0.id', $role1->getHashedKey())
                ->where('data.roles.data.1.id', $role2->getHashedKey())
                ->etc()
        );
    }
}
