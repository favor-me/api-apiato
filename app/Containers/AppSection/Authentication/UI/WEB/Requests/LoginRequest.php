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

namespace App\Containers\AppSection\Authentication\UI\WEB\Requests;

use App\Ship\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess'
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'password' => 'required|min:3|max:30'
        ];

        return loginAttributeValidationRulesMerger($rules);
    }
}
