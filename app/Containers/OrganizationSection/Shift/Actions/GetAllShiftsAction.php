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

namespace App\Containers\OrganizationSection\Shift\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\OrganizationSection\Shift\Tasks\GetAllShiftsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllShiftsAction extends Action
{
    protected bool $forAuthUser = false;

    /**
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(mixed $limit = null): LengthAwarePaginator
    {
        $task = app(GetAllShiftsTask::class);

        if ($this->forAuthUser) {
            $task->forAuthUser();
        }

        return $task
            ->addRequestCriteria(null, [
                CREATED_BY
            ])
            ->run($limit);
    }

    public function forAuthUser(): self
    {
        $this->forAuthUser = true;
        return $this;
    }
}
