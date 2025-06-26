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

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Ship\Exceptions\NotFoundException;
use Exception;

class FindUserByPhoneNumberTask extends UserTask
{
    /**
     * @param string $phoneNumber
     * @return User
     * @throws NotFoundException
     */
    public function run(mixed $phoneNumber): User
    {
        try {
            return $this->repository
                ->findByField(BaseUser::PHONE_NUMBER, $phoneNumber)
                ->first();
        } catch (Exception $e) {
            throw new NotFoundException();
        }
    }
}
