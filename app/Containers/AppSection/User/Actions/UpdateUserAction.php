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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class UpdateUserAction extends Action
{
    /**
     * @param UpdateUserDto $dto
     * @return User
     * @throws InternalErrorException
     * @throws NotFoundException
     */
    public function run(UpdateUserDto $dto): User
    {
        return app(UpdateUserTask::class)->run($dto);
    }
}
