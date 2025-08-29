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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\UserIsNotOrganizationOwnerException;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Ship\Exceptions\NotFoundException;
use Prettus\Repository\Exceptions\RepositoryException;

class FindOwnUserByIdAction extends Action
{
    protected UserModel $authUser;

    public function __construct()
    {
        $this->authUser = Auth::user();
    }

    /**
     * @param int $id
     * @return UserModel
     * @throws NotFoundException
     * @throws RepositoryException
     * @throws UserIsNotOrganizationOwnerException
     */
    public function run(int $id): UserModel
    {
        $this->checkAuthUserIsOrganizationOwner();

        return app(FindUserByIdTask::class)
            ->organization($this->authUser->organization_id)
            ->run($id);
    }

    /**
     * @return void
     * @throws UserIsNotOrganizationOwnerException
     */
    public function checkAuthUserIsOrganizationOwner(): void
    {
        if (!$this->authUser->is_organization_owner || is_null($this->authUser->organization_id)) {
            throw new UserIsNotOrganizationOwnerException();
        }
    }
}
