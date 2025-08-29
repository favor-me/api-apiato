<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Actions\FindOwnUserByIdAction;
use App\Containers\AppSection\User\Exceptions\UserIsNotOrganizationOwnerException;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Ship\Exceptions\NotFoundException;

final class FindOwnUserByIdActionTest extends UnitTestCase
{
    public function testUserIsNotOrganizationOwner(): void
    {
        $this->expectException(UserIsNotOrganizationOwnerException::class);
        $this->getTestingUser();
        $user = UserModel::factory()->create();
        app(FindOwnUserByIdAction::class)->run($user->id);
    }

    public function testNotExistsUser(): void
    {
        $this->expectException(NotFoundException::class);

        $this->getTestingOwnerUser();
        $user = UserModel::factory()->create();
        app(FindOwnUserByIdAction::class)->run($user->id);
    }

    public function testSuccess(): void
    {
        $owner = $this->getTestingOwnerUser();

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $owner->organization_id
            ]);

        $result = app(FindOwnUserByIdAction::class)->run($user->id);

        $this->assertInstanceOf(UserModel::class, $result);
        $this->assertSame($user->id, $result->id);
    }

    protected function getTestingOwnerUser(): UserModel
    {
        $organization = Organization::factory()->create();

        return $this->getTestingUser([
            User::IS_ORGANIZATION_OWNER => true,
            User::ORGANIZATION_ID => $organization->id
        ], [
            ROLES => RoleModel::ORGANIZATION_OWNER
        ]);
    }
}
