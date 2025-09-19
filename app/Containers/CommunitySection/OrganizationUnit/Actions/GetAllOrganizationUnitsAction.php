<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\GetAllOrganizationUnitsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Traits\Actions\SettableOrganization;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsAction extends Action
{
    use SettableOrganization;

    /**
     * @param bool $onlyTrashed
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(bool $onlyTrashed = false, mixed $limit = null): LengthAwarePaginator
    {
        $task = app(GetAllOrganizationUnitsTask::class);

        if ($onlyTrashed) {
            $task->onlyTrashed();
        }

        if (!is_null($this->organizationId)) {
            $task->organization($this->organizationId);
        }

        return $task
            ->addRequestCriteria()
            ->run($limit);
    }
}
