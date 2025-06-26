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

class RevokeUserFromRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles/revoke';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-admins-access'
    ];

    public function testRevokeUserFromRole(): void
    {
        $roleA = Role::factory()->create();

        $randomUser = User::factory()->create();
        $randomUser->assignRole($roleA);

        $data = [
            'roles_ids' => [$roleA->getHashedKey()],
            'user_id' => $randomUser->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.' . ID, $data['user_id'])
                ->etc()
        );

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->id,
            'role_id' => $roleA->id
        ]);
    }

    public function testRevokeUserFromManyRoles(): void
    {
        $roleA = Role::factory()->create();
        $roleB = Role::factory()->create();

        $randomUser = User::factory()->create();
        $randomUser->assignRole($roleA);
        $randomUser->assignRole($roleB);

        $data = [
            'roles_ids' => [
                $roleA->getHashedKey(),
                $roleB->getHashedKey()
            ],
            'user_id' => $randomUser->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->id,
            'role_id' => $roleA->id
        ]);

        $this->assertDatabaseMissing(config('permission.table_names.model_has_roles'), [
            'model_id' => $randomUser->id,
            'role_id' => $roleB->id
        ]);
    }
}
