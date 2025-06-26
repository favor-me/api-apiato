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
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Ship\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class ProxyLoginPasswordGrantRequest
 *
 * @package App\Containers\AppSection\Authentication\UI\API\Requests
 */
class ProxyLoginPasswordGrantRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [

    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [

    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'password' => 'required|min:3|max:30',
        ];

        $rules = loginAttributeValidationRulesMerger($rules);

        return $rules;
    }

    public function messages(): array
    {
        return [
            BaseUser::LOGIN . '.exists' => Container::trans('validation.login.exists'),
            BaseUser::LOGIN . '.required_without_all' => Container::trans('validation.login.required_without_all'),
            BaseUser::EMAIL . '.exists' => Container::trans('validation.email.exists'),
            BaseUser::EMAIL . '.required_without_all' => Container::trans('validation.email.required_without_all'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->setMessage(Container::trans('authentication.failed'));
    }
}
