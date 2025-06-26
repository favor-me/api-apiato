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

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class AttachPermissionsToRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/attach';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testAttachSinglePermissionToRole(): void
    {
        $roleA = Role::factory()->create();
        $permissionA = Permission::factory()->create();

        $data = [
            'role_id' => $roleA->getHashedKey(),
            'permissions_ids' => $permissionA->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.name', $roleA['name'])
                ->etc()
        );

        $this->assertDatabaseHas(config('permission.table_names.role_has_permissions'), [
            'permission_id' => $permissionA->id,
            'role_id' => $roleA->id
        ]);
    }

    public function testAttachMultiplePermissionToRole(): void
    {
        $roleA = Role::factory()->create();
        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();

        $data = [
            'role_id' => $roleA->getHashedKey(),
            'permissions_ids' => [
                $permissionA->getHashedKey(),
                $permissionB->getHashedKey()
            ]
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.id', $data['role_id'])
                ->has('data.permissions.data', count($data['permissions_ids']))
                ->where('data.permissions.data.0.id', $permissionA->getHashedKey())
                ->where('data.permissions.data.1.id', $permissionB->getHashedKey())
                ->etc()
        );

        $this->assertDatabaseHas(config('permission.table_names.role_has_permissions'), [
            'permission_id' => $permissionB->id,
            'role_id' => $roleA->id
        ]);
    }
}
