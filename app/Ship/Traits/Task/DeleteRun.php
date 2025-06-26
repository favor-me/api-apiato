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
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

trait DeleteRun
{
    /**
     * @param array $ids
     * @param bool $checkOnlyTrashed
     * @return int
     * @throws NotFoundException
     */
    public function run(array $ids, bool $checkOnlyTrashed = true): int
    {
        try {
            return $this->delete($ids, $checkOnlyTrashed);
        } catch (Exception) {
            throw new NotFoundException();
        }
    }

    /**
     * @param array $ids
     * @param bool $checkOnlyTrashed
     * @return int
     * @throws RepositoryException
     */
    protected function delete(array $ids, bool $checkOnlyTrashed = true): int
    {
        if ($checkOnlyTrashed) {
            $this->onlyTrashed();
        }

        return $this->repository
            ->pushCriteria(new InCriteria($ids))
            ->forceDelete();
    }
}
