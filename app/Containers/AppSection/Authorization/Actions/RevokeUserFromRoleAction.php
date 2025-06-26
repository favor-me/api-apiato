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
use App\Ship\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;

/**
 * Class RevokeUserFromRoleAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class RevokeUserFromRoleAction extends Action
{
    /**
     * Run action.
     *
     * @param   RevokeUserFromRoleRequest $request
     * @return  User
     *
     * @throws  NotFoundException
     */
    public function run(RevokeUserFromRoleRequest $request): User
    {
        $user = null;

        // if user ID is passed then convert it to instance of User (could be user Id Or Model)
        if (!$request->user_id instanceof User) {
            $user = app(FindUserByIdTask::class)->run($request->user_id);
        }

        // convert to array in case single ID was passed (could be Single Or Multiple Role Ids)
        $rolesIds = (array)$request->roles_ids;

        $roles = new Collection();

        foreach ($rolesIds as $roleId) {
            $role = app(FindRoleTask::class)->run($roleId);
            $roles->add($role);
        }

        foreach ($roles->pluck('name')->toArray() as $roleName) {
            $user->removeRole($roleName);
        }

        return $user;
    }
}
