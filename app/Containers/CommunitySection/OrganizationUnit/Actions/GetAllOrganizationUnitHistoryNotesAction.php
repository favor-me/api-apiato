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

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\HistorySection\ModelNote\Tasks\GetAllModelNotesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Apiato\Core\Exceptions\CoreInternalErrorException;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitHistoryNotesAction extends Action
{
    /**
     * @param string|int $id
     * @param int|string|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(string|int $id, null|int|string $limit = null): LengthAwarePaginator
    {
        return app(GetAllModelNotesTask::class)
            ->addRequestCriteria()
            ->forModel(OrganizationUnit::class)
            ->modelId($id)
            ->run($limit);
    }
}
