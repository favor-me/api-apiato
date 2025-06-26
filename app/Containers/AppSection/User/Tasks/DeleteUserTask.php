<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Tasks;

use App\Ship\Exceptions\DeleteResourceFailedException;
use Exception;

class DeleteUserTask extends UserTask
{
    /**
     * @param array $ids
     * @return int|null
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): ?int
    {
        try {
            return $this->deleteUser($ids);
        } catch (Exception $exception) {
            $this->errorDeleteUser($exception);
        }
    }

    /**
     * @param array $ids
     * @throws DeleteResourceFailedException
     */
    protected function checkCanDelete(array $ids): void
    {
        $this
            ->checkHasIds($ids)
            ->checkHasSuperUser($ids);
    }

    /**
     * @param array $ids
     * @return $this
     * @throws DeleteResourceFailedException
     */
    protected function checkHasIds(array $ids): self
    {
        $countUsers = $this->repository->count([
            ['id', 'in', $ids]
        ]);

        if ($countUsers == 0) {
            throw new DeleteResourceFailedException(__('ship::exception.no_resources_found_to_delete'));
        }

        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     * @throws DeleteResourceFailedException
     */
    protected function checkHasSuperUser(array $ids): self
    {
        $superUser = $this->repository->getSuperUser();
        if (in_array($superUser->id, $ids)) {
            throw new DeleteResourceFailedException(__('ship::exception.unable_to_remove_superuser'));
        }

        return $this;
    }

    /**
     * @param array $ids
     * @return int|null
     * @throws DeleteResourceFailedException
     */
    protected function deleteUser(array $ids): ?int
    {
        $this->checkCanDelete($ids);
        return $this->repository->deleteWhere([
            ['id', 'in', $ids]
        ]);
    }

    /**
     * @param Exception $e
     * @throws DeleteResourceFailedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function errorDeleteUser(Exception $e): void
    {
        throw new DeleteResourceFailedException($e->getMessage(), $e->getCode());
    }
}
