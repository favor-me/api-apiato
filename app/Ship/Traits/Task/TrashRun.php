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

use App\Ship\Exceptions\DeleteResourceFailedException;
use Exception;

trait TrashRun
{
    /**
     * @param array $ids
     * @return int|null
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): ?int
    {
        try {
            return $this->delete($ids);
        } catch (Exception $exception) {
            $this->failedDelete($exception);
        }
    }

    protected function delete(array $ids): ?int
    {
        return $this->repository->deleteWhere([
            [ID, 'in', $ids]
        ]);
    }

    /**
     * @param Exception $exception
     * @return void
     * @throws DeleteResourceFailedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function failedDelete(Exception $exception): void
    {
        throw new DeleteResourceFailedException();
    }
}
