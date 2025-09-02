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

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;

class DeleteUserRequest extends UserApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => Role::ADMIN,
        PERMISSIONS => 'delete-users'
    ];

    protected array $decode = [
        IDS . '.*'
    ];

    public function rules(): array
    {
        return [
            IDS => $this->getUserIdValidationRules()
        ];
    }

    public function getUserIdValidationRules(): ValidationRules
    {
        return parent::getUserIdValidationRules()
            ->addRequired();
    }
}
