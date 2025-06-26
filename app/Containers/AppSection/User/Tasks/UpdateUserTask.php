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

use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateUserTask extends UserTask
{
    /**
     * @param UpdateUserDto $dto
     * @return User
     * @throws NotFoundException
     * @throws InternalErrorException
     */
    public function run(UpdateUserDto $dto): User
    {
        try {
            $dto->checkCanDo();
            return $this->updateUser($dto);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundException(__('appSection@user::user.not_found'));
        } catch (Exception $exception) {
            throw new InternalErrorException($exception->getMessage(), (int) $exception->getCode());
        }
    }

    /**
     * @param UpdateUserDto $dto
     * @return User
     * @throws ValidatorException
     */
    protected function updateUser(UpdateUserDto $dto): User
    {
        $dto->hashPassword();
        $user = $this->repository->update($dto->getData(), $dto->id);
        $this->updateUserProfile($user, $dto);
        return $user;
    }

    protected function updateUserProfile(User $user, UpdateUserDto $dto): void
    {
        if (count($dto->profile)) {
            $user->profile()->update($dto->profile);
        }
    }
}
