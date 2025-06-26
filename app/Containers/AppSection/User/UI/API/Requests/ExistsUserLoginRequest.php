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

use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Ship\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ExistsUserLoginRequest extends UserApiRequest
{
    use HasUserValidationRules;

    protected array $urlParameters = [
        'login'
    ];

    public function rules(): array
    {
        return [
            'login' => $this->getUserLoginValidationRules()->addRequired()
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))->setMessage(__('appSection@user::user.login_cant_be_used'));
    }
}
