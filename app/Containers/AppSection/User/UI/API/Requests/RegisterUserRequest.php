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

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Contracts\GettableDto;
use App\Ship\Dto\Dto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegisterUserRequest extends UserApiRequest implements GettableDto
{
    public function getUserNameValidationRules(): ValidationRulesCollection
    {
        return parent::getUserNameValidationRules()
            ->addRequired();
    }

    public function getUserPasswordValidationRules(): ValidationRulesCollection
    {
        return parent::getUserPasswordValidationRules()
            ->addRequired();
    }

    public function rules(): array
    {
        return $this->getUserRules();
    }

    /**
     * @return RegisterUserDto
     * @throws UnknownProperties
     */
    public function getDto(): RegisterUserDto
    {
        return $this->newDto($this->getDtoData());
    }

    /**
     * @param array $data
     * @return RegisterUserDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): RegisterUserDto
    {
        return new RegisterUserDto($data);
    }

    protected function getDtoData(): array
    {
        return $this->validated();
    }
}
