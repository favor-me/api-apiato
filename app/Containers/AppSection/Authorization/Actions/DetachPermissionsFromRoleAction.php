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
use App\Containers\AppSection\Authorization\Tasks\DetachPermissionsFromRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\DetachPermissionToRoleRequest;

/**
 * Class DetachPermissionsFromRoleAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class DetachPermissionsFromRoleAction extends Action
{
    /**
     * Run action.
     *
     * @param   DetachPermissionToRoleRequest $request
     *
     * @return  Role
     */
    public function run(DetachPermissionToRoleRequest $request): Role
    {
        $role = app(FindRoleTask::class)->run($request->role_id);
        return app(DetachPermissionsFromRoleTask::class)->run($role, $request->permissions_ids);
    }
}
