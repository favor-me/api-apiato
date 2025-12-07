<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\GetAllOrganizationUnitsTask;
use App\Containers\CommunitySection\OrganizationUnit\Traits\SetPriceFrom;
use App\Ship\Parents\Actions\Action;
use App\Ship\Traits\Actions\SettableOrganization;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsAction extends Action
{
    use SetPriceFrom;
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

        if ($this->hasPriceFrom()) {
            $task->setPriceFrom($this->priceFrom);
        }

        return $task
            ->addRequestCriteria()
            ->run($limit);
    }
}
