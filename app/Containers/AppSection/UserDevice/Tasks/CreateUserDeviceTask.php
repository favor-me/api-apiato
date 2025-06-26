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

use App\Containers\AppSection\UserDevice\Dto\CreateUserDeviceDto;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Exceptions\CreateResourceFailedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateUserDeviceTask extends UserDeviceTask
{
    /**
     * @param CreateUserDeviceDto $dto
     * @return UserDevice
     * @throws CreateResourceFailedException
     */
    public function run(CreateUserDeviceDto $dto): UserDevice
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateUserDeviceDto $dto
     * @return UserDevice
     * @throws ValidatorException
     */
    protected function create(CreateUserDeviceDto $dto): UserDevice
    {
        return $this->repository->create($dto->toArray());
    }

    /**
     * @param Exception $exception
     * @throws CreateResourceFailedException
     */
    protected function errorCreate(Exception $exception): void
    {
        throw new CreateResourceFailedException($exception->getMessage());
    }
}
