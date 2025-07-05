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

use App\Containers\AppSection\User\Models\User;
use App\Ship\Collections\ValidationRules;

class ForgotPasswordRequest extends ResetPasswordRequest
{
    public function rules(): array
    {
        return [
            'email' => $this->getUserEmailRules(),
            'reset_url' => $this->getResetUrlRules()
        ];
    }

    public function getUserEmailRules(): ValidationRules
    {
        return parent::getUserEmailRules()
            ->add('exists:' . User::TABLE . ',email');
    }

    public function getResetUrlRules(): array
    {
        return [
            'required',
            'max:255'
        ];
    }
}
