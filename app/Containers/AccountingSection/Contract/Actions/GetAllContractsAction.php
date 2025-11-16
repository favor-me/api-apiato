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

namespace App\Containers\AccountingSection\Contract\Actions;

use App\Containers\AccountingSection\Contract\Tasks\GetAllContractsTask;
use App\Ship\Parents\Actions\Action;
use Apiato\Core\Exceptions\CoreInternalErrorException;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllContractsAction extends Action
{
    /**
     * @param bool $onlyTrashed
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(bool $onlyTrashed = false, mixed $limit = null): LengthAwarePaginator
    {
        $task = app(GetAllContractsTask::class);

        if ($onlyTrashed) {
            $task->onlyTrashed();
        }

        return $task->addRequestCriteria()->run($limit);
    }
}
