<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelNote\Actions;

use App\Containers\HistorySection\ModelNote\Tasks\GetAllModelNotesTask;
use App\Ship\Parents\Actions\Action;
use Apiato\Core\Exceptions\CoreInternalErrorException;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllModelNotesAction extends Action
{
    /**
     * @param int|null $limit
     * @return LengthAwarePaginator
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(?int $limit = null): LengthAwarePaginator
    {
        return app(GetAllModelNotesTask::class)
            ->addRequestCriteria(null, [
                ID,
                CREATED_BY,
                BaseModelNote::MODEL_ID,
                BaseModelNote::EVENT_ID
            ])
            ->run($limit);
    }
}
