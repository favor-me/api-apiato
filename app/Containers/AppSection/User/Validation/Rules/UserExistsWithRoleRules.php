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

namespace App\Containers\AppSection\User\Validation\Rules;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\DB;

class UserExistsWithRoleRules extends ValidationRule
{
    public function __construct(
        protected string $role
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = DB::table('model_has_roles')
            ->leftJoin('roles', 'role_id', '=', 'roles.id')
            ->where('model_type', User::class)
            ->where('model_id', $value)
            ->where('name', $this->role)
            ->count([
                ID
            ]);

        if ($result === ZERO) {
            $fail(__('appSection@user::validation.exists_with_role'));
        }
    }
}
