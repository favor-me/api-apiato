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

namespace App\Ship\Traits\Task;

use App\Ship\Criterias\InCriteria;
use App\Ship\Exceptions\NotFoundException;
use Prettus\Repository\Exceptions\RepositoryException;
use Exception;

trait RestoreRun
{
    /**
     * @param array $ids
     * @return int
     * @throws NotFoundException
     */
    public function run(array $ids): int
    {
        try {
            return $this->restore($ids);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }

    /**
     * @param array $ids
     * @return int
     * @throws RepositoryException
     */
    protected function restore(array $ids): int
    {
        $this->onlyTrashed();
        $this->repository->pushCriteria(new InCriteria($ids));
        return $this->repository->restore();
    }
}
