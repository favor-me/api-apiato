<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\CommunitySection\OrganizationUnit\Dto\UpdateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

/**
 * @method UpdateOrganizationUnitDto getDto()
 */
class UpdateOrganizationUnitRequest extends CreateOrganizationUnitRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => Role::ORGANIZATION_OWNER
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getOrganizationUnitIdValidationRules()
        ]);
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationUnitIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationUnitIdExistsValidationRule($column)
            ->where(OrganizationUnit::ORGANIZATION_ID, $this->organization_id);
    }

    public function getOrganizationUnitSystemUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitSystemUnitIdValidationRules()
            ->removeRequired();
    }

    public function getOrganizationUnitNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitNameValidationRules()
            ->removeRequired();
    }

    public function getOrganizationUnitTypeValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitTypeValidationRules()
            ->removeRequired();
    }

    public function getOrganizationUnitOrganizationIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitOrganizationIdValidationRules()
            ->removeRequired();
    }

    public function getOrganizationUnitSkuUniqueValidationRule(): Unique
    {
        return parent::getOrganizationUnitSkuUniqueValidationRule()
            ->ignore($this->id);
    }

    public function getOrganizationUnitNameUniqueValidationRule(): Unique
    {
        return parent::getOrganizationUnitNameUniqueValidationRule()
            ->ignore($this->id);
    }

    public function newDto(array $data = []): UpdateOrganizationUnitDto
    {
        return new UpdateOrganizationUnitDto($data);
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
