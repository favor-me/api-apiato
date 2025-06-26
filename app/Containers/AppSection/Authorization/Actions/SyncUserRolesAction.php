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
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncUserRolesRequest;

/**
 * Class SyncUserRolesAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class SyncUserRolesAction extends Action
{
    /**
     * Run action.
     *
     * @param   SyncUserRolesRequest $request
     *
     * @return  User
     *
     * @throws  NotFoundException
     */
    public function run(SyncUserRolesRequest $request): User
    {
        $user = app(FindUserByIdTask::class)->run($request->user_id);

        // convert roles IDs to array (in case single id passed)
        $rolesIds = (array) $request->roles_ids;

        $roles = array_map(static function ($roleId) {
            return app(FindRoleTask::class)->run($roleId);
        }, $rolesIds);

        $user->syncRoles($roles);

        return $user;
    }
}
