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

namespace App\Containers\OrderSection\Order\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Tasks\GetAllOrdersTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Traits\Actions\SettableOrganization;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrdersAction extends Action
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
        $task = app(GetAllOrdersTask::class);

        if ($onlyTrashed) {
            $task->onlyTrashed();
        }

        if (!is_null($this->organizationId)) {
            $task->organization($this->organizationId);
        }

        return $task
            ->addRequestCriteria(null, [
                Order::ORGANIZATION_ID,
                Order::CLIENT_ID,
                Order::STATUS_ID,
                CREATED_BY,
                UPDATED_BY
            ])
            ->run($limit);
    }
}
