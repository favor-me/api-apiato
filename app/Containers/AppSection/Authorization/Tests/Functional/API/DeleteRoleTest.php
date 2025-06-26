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

class DeleteRoleTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/roles/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testDeleteExistingRole(): void
    {
        $role = Role::factory()->create();

        $this
            ->injectId($role->id)
            ->makeCall();

        $this->response->assertNoContent();
    }
}
