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

class SyncPermissionsOnRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/permissions/sync';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testSyncDuplicatedPermissionsToRole(): void
    {
        $permissionA = Permission::factory()
            ->create([
                'display_name' => 'AAA'
            ]);

        $permissionB = Permission::factory()
            ->create([
                'display_name' => 'BBB'
            ]);

        $roleA = Role::factory()->create();
        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id' => $roleA->getHashedKey(),
            'permissions_ids' => [
                $permissionA->getHashedKey(),
                $permissionB->getHashedKey()
            ]
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->assertDatabaseHas(config('permission.table_names.role_has_permissions'), [
            'permission_id' => $permissionB->id,
            'role_id' => $roleA->id
        ]);
    }
}
