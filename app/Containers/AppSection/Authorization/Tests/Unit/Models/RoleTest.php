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

namespace App\Containers\AppSection\Authorization\Tests\Unit\Models;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;

class RoleTest extends UnitTestCase
{
    public function testGetDisplayNameAttribute(): void
    {
        /** @var Role $role */
        $role = app(RoleRepository::class)->findWhere([
            ['name' , '=', Role::SPECIALIST]
        ])->first();

        $this->assertSame(__('appSection@authorization::role.specialist.display_name'), $role->display_name);

        $role = Role::factory()->create([
            'display_name' => 'Custom name'
        ]);

        $this->assertSame('Custom name', $role->display_name);
    }
}
