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

namespace App\Containers\AppSection\Authorization\Actions;

use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindRoleRequest;
use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;

/**
 * Class FindRoleAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class FindRoleAction extends Action
{
    /**
     * Run action.
     *
     * @param   FindRoleRequest $request
     *
     * @return  Role
     *
     * @throws  RoleNotFoundException
     */
    public function run(FindRoleRequest $request): Role
    {
        $role = app(FindRoleTask::class)->run($request->id);

        if (!$role) {
            throw new RoleNotFoundException();
        }

        return $role;
    }
}
