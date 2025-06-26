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

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Containers\AppSection\Authentication\Facades\Container;
use App\Ship\Parents\Requests\Request;
use App\Containers\AppSection\User\Foundation\User;
use App\Ship\Requests\ApiRequest;
use App\Ship\Utils\Str;
use App\Ship\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProxyLoginPasswordGrantRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess'
        ]);
    }

    public function rules(): array
    {
        return loginAttributeValidationRulesMerger([
            User::PASSWORD => 'required|min:3|max:30',
        ]);
    }

    public function messages(): array
    {
        return [
            User::LOGIN . '.exists' => Container::trans('validation.login.exists'),
            User::LOGIN . '.required_without_all' => Container::trans('validation.login.required_without_all'),
            User::EMAIL . '.exists' => Container::trans('validation.email.exists'),
            User::EMAIL . '.required_without_all' => Container::trans('validation.email.required_without_all'),
            User::PHONE_NUMBER . '.exists' => Container::trans('validation.phone_number.exists'),
            User::PHONE_NUMBER . '.required_without_all' => Container::trans('validation.phone_number.required_without_all'),
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has(User::PHONE_NUMBER)) {
            $this->merge([
                User::PHONE_NUMBER => (string)Str::toPhoneNumber($this->get(User::PHONE_NUMBER))
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->setMessage(Container::trans('authentication.failed'));
    }
}
