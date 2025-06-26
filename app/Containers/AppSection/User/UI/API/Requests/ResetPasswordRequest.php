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
use App\Ship\Collections\ValidationRulesCollection;

class ResetPasswordRequest extends UserApiRequest
{
    public function getUserEmailRules(): ValidationRulesCollection
    {
        return parent::getUserEmailValidationRules()
            ->removeUnique()
            ->addRequired();
    }

    public function getUserPasswordRules(): ValidationRulesCollection
    {
        return parent::getUserPasswordValidationRules()->addRequired();
    }

    public function getUserTokenRules(): array
    {
        return [
            'required',
            'max:255'
        ];
    }

    public function rules(): array
    {
        return [
            'token' => $this->getUserTokenRules(),
            'email' => $this->getUserEmailRules(),
            'password' => $this->getUserPasswordRules()
        ];
    }
}
