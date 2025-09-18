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

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\User\Models\User;

trait IsOrganizationUser
{
    public function isOrganizationUser(): bool
    {
        /** @var User $user */
        $user = app(GetAuthenticatedUserTask::class)->run();
        return !is_null($user->organization_id);
    }
}
