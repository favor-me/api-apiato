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

use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateUserByCredentialsTask extends UserTask
{
    /**
     * @param RegisterUserDto $dto
     * @return User
     * @throws CreateResourceFailedException
     */
    public function run(RegisterUserDto $dto): User
    {
        try {
            return $this->createUser($dto);
        } catch (Exception $e) {
            $this->errorCreateUser($e);
        }
    }

    /**
     * @param RegisterUserDto $dto
     * @return User
     * @throws ValidatorException
     */
    protected function createUser(RegisterUserDto $dto): User
    {
        $dto->hashPassword();
        return $this->repository->create($dto->getData());
    }

    /**
     * @param Exception $e
     * @throws CreateResourceFailedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function errorCreateUser(Exception $e): void
    {
        throw new CreateResourceFailedException($e->getMessage());
    }
}
