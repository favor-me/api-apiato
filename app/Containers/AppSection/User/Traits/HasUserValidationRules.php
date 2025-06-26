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
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Validation\Rule;
use Illuminate\Database\Query\Builder;

trait HasUserValidationRules
{
    public function getUserAvatarValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.avatar'));
    }

    public function getUserBirthValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.birth'));
    }

    public function getUserEmailValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.email'));
    }

    public function getUserGenderValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.gender'));
    }

    public function getUserIdValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.id'));
    }

    public function getUserLoginValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.login'));
    }

    public function getUserNameValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.name'));
    }

    public function getUserPasswordValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.password'));
    }

    public function getUserPatronymicValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.patronymic'));
    }

    public function getUserPhoneNumberValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.phone_number'));
    }

    public function getUserRegistrationRolesValidationRules(): ValidationRulesCollection
    {
        return validation_rules([
            Rule::exists(app(Role::class)->getTable(), 'name')->where(function (Builder $query) {
                $query->whereNotIn('name', [Role::ADMIN]);
            })
        ]);
    }

    public function getUserSurnameValidationRules(): ValidationRulesCollection
    {
        return validation_rules(config('appSection-user.rules.surname'));
    }
}
