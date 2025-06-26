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

namespace App\Containers\AppSection\User\UI\WEB\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Contracts\GettableDto;
use App\Ship\Requests\FormRequest;
use App\Ship\Utils\Str;
use App\Ship\Validation\Rule;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegistrationRequest extends FormRequest implements GettableDto
{
    use HasUserValidationRules;

    /**
     * @return RegisterUserDto
     * @throws UnknownProperties
     */
    public function getDto(): RegisterUserDto
    {
        return $this->newDto($this->validated());
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

    public function rules(): array
    {
        return [
            'role' => $this->getRoleValidationRules()->addRequired(),
            'surname' => $this->getUserSurnameValidationRules()->addRequired(),
            'name' => $this->getUserNameValidationRules()->addRequired(),
            'patronymic' => $this->getUserPatronymicValidationRules()->addRequired(),
            'email' => $this->getUserEmailValidationRules(),
            'phone_number' => $this->getUserPhoneNumberValidationRules()->addRequired(),
            'password' => $this->getUserPasswordValidationRules()->addRequired()->add('confirmed'),
            'password_confirmation' => $this->getUserPasswordValidationRules()->addRequired()
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone_number' => Str::toPhoneNumber($this->get('phone_number'))
        ]);
    }

    public function getRoleValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            Rule::in([
                Role::SPECIALIST,
                Role::CLIENT
            ])
        ])->addRequired();
    }
}
