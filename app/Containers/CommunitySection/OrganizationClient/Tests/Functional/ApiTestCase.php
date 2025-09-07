<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Functional;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\FunctionalTestCase;

abstract class ApiTestCase extends FunctionalTestCase
{
    public function getTestingOrganizationUser(?array $userDetails = null, ?array $access = null): UserModel
    {
        $user = $this->getTestingUser($userDetails, $access);

        $organization = OrganizationModel::factory()
            ->create([
                Organization::USER_OWNER_ID => $user->id
            ]);

        $user->setAttribute(User::ORGANIZATION_ID, $organization->id);
        $user->update();

        return $user;
    }
}
