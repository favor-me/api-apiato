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

namespace App\Containers\OrderSection\Status\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\OrderSection\Status\Tasks\GetAllStatusesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllStatusesAction extends Action
{
    /**
     * @param mixed|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(mixed $limit = null): LengthAwarePaginator
    {
        return app(GetAllStatusesTask::class)
            ->addRequestCriteria()
            ->run($limit);
    }
}
