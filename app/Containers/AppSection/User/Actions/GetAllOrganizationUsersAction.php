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

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUsersAction extends Action
{
    /**
     * @param mixed $organization
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(mixed $organization, mixed $exclude = null): LengthAwarePaginator
    {
        if ($organization instanceof Organization) {
            $organization = $organization->id;
        }

        $task = app(GetAllUsersTask::class);

        if (!is_null($exclude)) {
            $task->exclude((array)$exclude);
        }

        return $task
            ->addRequestCriteria()
            ->fromOrganization($organization)
            ->ordered()
            ->run();
    }
}
