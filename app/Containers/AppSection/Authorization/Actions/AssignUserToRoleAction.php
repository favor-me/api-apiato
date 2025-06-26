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
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\AssignUserToRoleRequest;

/**
 * Class AssignUserToRoleAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class AssignUserToRoleAction extends Action
{
    /**
     * Run action.
     *
     * @param   AssignUserToRoleRequest $request
     *
     * @return  User
     *
     * @throws  NotFoundException
     */
    public function run(AssignUserToRoleRequest $request): User
    {
        $user = app(FindUserByIdTask::class)->run($request->user_id);

        // convert to array in case single ID was passed
        $rolesIds = (array) $request->roles_ids;

        $roles = array_map(static function ($roleId) {
            return app(FindRoleTask::class)->run($roleId);
        }, $rolesIds);

        return app(AssignUserToRoleTask::class)->run($user, $roles);
    }
}
