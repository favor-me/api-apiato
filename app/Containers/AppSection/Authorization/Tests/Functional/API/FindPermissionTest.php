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
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class FindPermissionTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/permissions/{id}';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testFindPermissionById(): void
    {
        $permissionA = Permission::factory()->create();

        $this
            ->injectId($permissionA->id)
            ->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.name', $permissionA->name)
                ->etc()
        );
    }
}
