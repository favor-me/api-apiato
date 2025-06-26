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

use App\Containers\AppSection\UserDevice\Dto\UpdateUserDeviceDto;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateUserDeviceTask extends UserDeviceTask
{
    /**
     * @param UpdateUserDeviceDto $dto
     * @return UserDevice
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateUserDeviceDto $dto): UserDevice
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param Exception $exception
     * @return void
     * @throws UpdateResourceFailedException
     */
    protected function errorUpdate(Exception $exception): void
    {
        throw new UpdateResourceFailedException($exception->getMessage());
    }

    /**
     * @param UpdateUserDeviceDto $dto
     * @return UserDevice
     * @throws ValidatorException
     */
    protected function update(UpdateUserDeviceDto $dto): UserDevice
    {
        $data = $dto->except(ID)->toArray(true);
        return $this->repository->update($data, $dto->id);
    }
}
