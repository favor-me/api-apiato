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

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rules\Exists;

trait HasUserValidationRules
{
    public function getUserAvatarValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.avatar'));
    }

    public function getUserBirthValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.birth'));
    }

    public function getUserEmailValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.email'));
    }

    public function getUserGenderValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.gender'));
    }

    public function getUserIdValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.id'));
    }

    public function getUserLoginValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.login'));
    }

    public function getUserNameValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.name'));
    }

    public function getUserPasswordValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.password'));
    }

    public function getUserPatronymicValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.patronymic'));
    }

    public function getUserPhoneNumberValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.phone_number'));
    }

    public function getUserRegistrationRolesValidationRules(): ValidationRules
    {
        return validation_rules([
            Rule::exists(app(Role::class)->getTable(), 'name')->where(function (Builder $query) {
                $query->whereNotIn('name', [Role::ADMIN]);
            })
        ]);
    }

    public function getUserSurnameValidationRules(): ValidationRules
    {
        return validation_rules(config('appSection-user.rules.surname'));
    }

    public function getUserExistsInOrganizationValidationRule(mixed $organizationId): Exists
    {
        return Rule::exists(UserModel::TABLE, ID)
            ->where(User::ORGANIZATION_ID, $organizationId);
    }
}
