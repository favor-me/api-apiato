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

namespace App\Containers\AppSection\User\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformerManager;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use App\Ship\Traits\Validation\HasParamsValidationRules;
use App\Ship\Utils\Str;

abstract class UserApiRequest extends ApiRequest implements GettableTransformer
{
    use HasUserValidationRules;
    use HasParamsValidationRules;

    public function messages(): array
    {
        return [
            'name.min' => __('appSection@user::validation.name.min'),
            'login.unique' => __('appSection@user::validation.login.unique'),
            'surname.min' => __('appSection@user::validation.surname.min'),
            'token.required' => __('appSection@user::validation.token.required'),
            'patronymic.min' => __('appSection@user::validation.patronymic.min')
        ];
    }

    public function getTransformer(): Transformer
    {
        return (new UserTransformerManager())->getDefaultOrAdmin();
    }

    protected function getUserRules(): array
    {
        return [
            User::NAME => $this->getUserNameValidationRules(),
            User::EMAIL => $this->getUserEmailValidationRules(),
            User::BIRTH => $this->getUserBirthValidationRules(),
            User::LOGIN => $this->getUserLoginValidationRules(),
            User::GENDER => $this->getUserGenderValidationRules(),
            User::SURNAME => $this->getUserSurnameValidationRules(),
            User::PASSWORD => $this->getUserPasswordValidationRules(),
            User::PATRONYMIC => $this->getUserPatronymicValidationRules(),
            User::PHONE_NUMBER => $this->getUserPhoneNumberValidationRules(),
            User::SHIFT_PARAMS => $this->getParamsValidationRules(),
            'role' => $this->getUserRegistrationRolesValidationRules()
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->clearPhoneNumber();
    }

    protected function clearPhoneNumber(): void
    {
        $key = User::PHONE_NUMBER;
        if ($this->has($key)) {
            $this->merge([
                $key => Str::toPhoneNumber($this->get($key))
            ]);
        }
    }
}
