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

use Illuminate\Support\Facades\App;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\FindPermissionTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindPermissionRequest;
use App\Containers\AppSection\Authorization\Exceptions\PermissionNotFoundException;

/**
 * Class FindPermissionAction
 *
 * @package App\Containers\AppSection\Authorization\Actions
 */
class FindPermissionAction extends Action
{
    /**
     * Run action.
     *
     * @param   FindPermissionRequest $request
     *
     * @return  Permission
     *
     * @throws  PermissionNotFoundException
     */
    public function run(FindPermissionRequest $request): Permission
    {
        $permission = App::make(FindPermissionTask::class)->run($request->id);

        if (!$permission) {
            throw new PermissionNotFoundException();
        }

        return $permission;
    }
}
