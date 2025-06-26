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

class DetachPermissionsFromRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/detach';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testDetachSinglePermissionFromRole(): void
    {
        $permissionA = Permission::factory()->create();

        $roleA = Role::factory()->create();
        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id' => $roleA->getHashedKey(),
            'permissions_ids' => [
                $permissionA->getHashedKey()
            ]
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.name', $roleA->name)
                ->etc()
        );

        $this->assertDatabaseMissing(config('permission.table_names.role_has_permissions'), [
            'permission_id' => $permissionA->id,
            'role_id' => $roleA->id
        ]);
    }

    public function testDetachMultiplePermissionFromRole(): void
    {
        $permissionA = Permission::factory()->create();
        $permissionB = Permission::factory()->create();

        $roleA = Role::factory()->create();
        $roleA->givePermissionTo($permissionA);
        $roleA->givePermissionTo($permissionB);

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
                ->where('data.name', $roleA->name)
                ->etc()
        );

        $this->assertDatabaseMissing(config('permission.table_names.role_has_permissions'), [
            'permission_id' => $permissionA->id,
            'role_id' => $roleA->id
        ]);
    }
}
