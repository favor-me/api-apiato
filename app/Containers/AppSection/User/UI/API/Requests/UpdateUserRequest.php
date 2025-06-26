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

use App\Containers\AppSection\Profile\Models\Profile;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\Traits\IsOwnerTrait;
use App\Containers\LocationSection\Provider\Traits\HasLocationRequest;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Traits\Request\HasInputId;

/**
 * @method User user($guard = null)
 */
class UpdateUserRequest extends UserApiRequest
{
    use HasInputId;
    use IsOwnerTrait;
    use HasLocationRequest;

    protected array $access = [
        'roles' => '',
        'permissions' => 'update-users'
    ];

    protected array $decode = [
        'id',
        'city_id',
        'region_id',
        'country_id'
    ];

    protected array $urlParameters = [
        'id'
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess|isOwner'
        ]);
    }

    public function getUserEmailValidationRules(): ValidationRulesCollection
    {
        return parent::getUserEmailValidationRules()->addIgnoreIdForUnique($this->getId());
    }

    public function getUserLoginRules(): ValidationRulesCollection
    {
        $profile = $this->user()->profile;
        $rules = parent::getUserLoginValidationRules();

        if ($profile instanceof Profile) {
            return $rules->addIgnoreIdForUnique($profile->id);
        }

        return $rules;
    }

    public function getUserLoginValidationRules(): ValidationRulesCollection
    {
        return parent::getUserLoginValidationRules()->addIgnoreIdForUnique($this->getId());
    }

    protected function getUserRules(): array
    {
        return array_merge(parent::getUserRules(), [
            'id' => $this->getUserIdValidationRules()->addRequired()
        ]);
    }

    public function getUserPhoneNumberValidationRules(): ValidationRulesCollection
    {
        return parent::getUserPhoneNumberValidationRules()->addIgnoreIdForUnique($this->getId());
    }

    public function rules(): array
    {
        $rules = array_merge(
            $this->getUserRules(),
            $this->getUserProfileRules()
        );

        $this->addLocationRules($rules);

        return $rules;
    }

    /**
     * @throws NotFoundException
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this
            ->mergeByCityId()
            ->mergeByRegionId();
    }
}
