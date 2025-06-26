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
use Spatie\Permission\Contracts\Role;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\Tasks\DeleteRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\DeleteRoleRequest;

/**
 * Class DeleteRoleAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class DeleteRoleAction extends Action
{
    /**
     * Run action.
     *
     * @param   DeleteRoleRequest $request
     *
     * @return  Role
     *
     * @throws  DeleteResourceFailedException
     */
    public function run(DeleteRoleRequest $request): Role
    {
        $role = app(FindRoleTask::class)->run($request->id);
        app(DeleteRoleTask::class)->run($role);

        return $role;
    }
}
