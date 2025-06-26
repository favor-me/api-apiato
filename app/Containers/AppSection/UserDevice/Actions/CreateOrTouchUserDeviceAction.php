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

namespace App\Containers\AppSection\UserDevice\Actions;

use App\Containers\AppSection\UserDevice\Dto\CreateUserDeviceDto;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Tasks\CreateUserDeviceTask;
use App\Containers\AppSection\UserDevice\Tasks\FindUserDeviceTask;
use App\Containers\AppSection\UserDevice\Tasks\TouchUserDeviceTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;

class CreateOrTouchUserDeviceAction extends Action
{
    /**
     * @param CreateUserDeviceDto $dto
     * @return UserDevice
     * @throws CreateResourceFailedException
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run(CreateUserDeviceDto $dto): UserDevice
    {
        $userDevice = app(FindUserDeviceTask::class)->run($dto->user_id, $dto->model);

        if ($userDevice instanceof UserDevice) {
            $userDevice->setAttribute(BaseUserDevice::TOKEN, $dto->token);
            return $this->touch($userDevice);
        }

        return $this->create($dto);
    }

    /**
     * @param CreateUserDeviceDto $dto
     * @return UserDevice
     * @throws CreateResourceFailedException
     */
    protected function create(CreateUserDeviceDto $dto): UserDevice
    {
        return app(CreateUserDeviceTask::class)->run($dto);
    }

    /**
     * @param UserDevice $userDevice
     * @return UserDevice
     * @throws UpdateResourceFailedException
     */
    protected function touch(UserDevice $userDevice): UserDevice
    {
        return app(TouchUserDeviceTask::class)->run($userDevice);
    }
}
