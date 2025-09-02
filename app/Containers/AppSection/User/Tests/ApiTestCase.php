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

namespace App\Containers\AppSection\User\Tests;

use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Foundation\User;

abstract class ApiTestCase extends FunctionalUnitTestCase
{
    protected function getTestingOwnerUser(): UserModel
    {
        $organization = OrganizationModel::factory()->create();

        $user = $this->getTestingUser([
            User::ORGANIZATION_ID => $organization->id,
            User::IS_ORGANIZATION_OWNER => true
        ]);

        $organization->setAttribute(Organization::USER_OWNER_ID, $user->id);
        $organization->update();

        return $user;
    }
}
