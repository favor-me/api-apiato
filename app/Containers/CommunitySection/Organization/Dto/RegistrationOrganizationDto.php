<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\Organization\Dto;

use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Validation\Rules\IsOwnerNameRule;

class RegistrationOrganizationDto extends CreateOrganizationDto
{
    public string $owner_name;
    public string $password;

    public function toRegisterUserDto(): RegisterUserDto
    {
        list ($surname, $name, $patronymic) = explode(IsOwnerNameRule::SEPARATOR, $this->owner_name);

        return new RegisterUserDto([
            User::PASSWORD => $this->password,
            User::SURNAME => $surname,
            User::NAME => $name,
            User::PATRONYMIC => $patronymic,
            User::PHONE_NUMBER => $this->phone_number
        ]);
    }
}
