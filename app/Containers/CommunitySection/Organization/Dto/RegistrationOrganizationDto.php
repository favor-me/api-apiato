<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\Organization\Dto;

use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Validation\Rules\IsOwnerNameRule;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class RegistrationOrganizationDto extends CreateOrganizationDto
{
    public string $password;
    public string $owner_name;

    /**
     * @return RegisterUserDto
     * @throws UnknownProperties
     */
    public function toRegisterUserDto(): RegisterUserDto
    {
        list ($surname, $name, $patronymic) = explode(IsOwnerNameRule::SEPARATOR, $this->owner_name);

        return new RegisterUserDto([
            User::NAME => $name,
            User::SURNAME => $surname,
            User::PATRONYMIC => $patronymic,
            User::PASSWORD => $this->password,
            User::PHONE_NUMBER => $this->phone_number
        ]);
    }
}
