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

use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class CreateRoleTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/roles';

    protected array $access = [
        'roles' => '',
        'permissions' => 'manage-roles'
    ];

    public function testCreateRole(): void
    {
        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
            'level' => 7
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.name', $data['name'])
                ->where('data.level', $data['level'])
                ->etc()
        );
    }

    public function testCreateRoleWithoutLevel(): void
    {
        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things'
        ];

        $this->makeCall($data);

        $this->response->assertOk();

        $this->response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('data')
                ->where('data.name', $data['name'])
                ->where('data.level', ZERO)
                ->etc()
        );
    }

    public function testCreateRoleWithWrongName(): void
    {
        $data = [
            'name' => 'include Space',
            'display_name' => 'manager',
            'description' => 'he manages things'
        ];

        $this->makeCall($data);

        $this->response->assertUnprocessable();
    }
}
