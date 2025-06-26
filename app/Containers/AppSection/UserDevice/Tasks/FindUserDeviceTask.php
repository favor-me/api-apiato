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

namespace App\Containers\AppSection\UserDevice\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Data\Criterias\UserDeviceCriteria;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Exceptions\NotFoundException;
use Prettus\Repository\Exceptions\RepositoryException;
use Exception;

class FindUserDeviceTask extends UserDeviceTask
{
    /**
     * @param mixed $user
     * @param string $device
     * @return UserDevice|null
     * @throws NotFoundException
     */
    public function run(mixed $user, string $device): ?UserDevice
    {
        try {
            return $this->find($user, $device);
        } catch (Exception $e) {
            $this->errorCreate($e);
        }
    }

    /**
     * @param mixed $user
     * @param string $device
     * @return UserDevice|null
     * @throws RepositoryException
     */
    protected function find(mixed $user, string $device): ?UserDevice
    {
        $user = $this->normalizeUser($user);
        return $this->repository
            ->pushCriteria(
                new UserDeviceCriteria($user, $device)
            )
            ->first();
    }

    /**
     * @param Exception $exception
     * @return void
     * @throws NotFoundException
     */
    protected function errorCreate(Exception $exception): void
    {
        throw new NotFoundException($exception->getMessage());
    }

    /**
     * @param mixed $user
     * @return int
     */
    protected function normalizeUser(mixed $user): int
    {
        return $user instanceof User ? $user->id : (int)$user;
    }
}
