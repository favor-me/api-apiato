<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use Illuminate\Validation\Rules\Unique;

class UpdateOwnOrganizationRequest extends UpdateOrganizationRequest
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER,
        PERMISSIONS => null
    ];

    protected array $urlParameters = [];

    public function getOrganizationNameUniqueValidationRule(): Unique
    {
        return parent::getOrganizationEmailUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationInnUniqueValidationRule(): Unique
    {
        return parent::getOrganizationInnUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationPhoneNumberUniqueValidationRule(): Unique
    {
        return parent::getOrganizationPhoneNumberUniqueValidationRule()
            ->ignore($this->id);
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }

    protected function isOrganizationOwner(): bool
    {
        return $this->user()->is_organization_owner;
    }
}
