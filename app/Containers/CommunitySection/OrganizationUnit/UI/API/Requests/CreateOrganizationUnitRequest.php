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

use App\Containers\CommunitySection\OrganizationUnit\Dto\CreateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Permissions\Permissions;
use App\Containers\CommunitySection\OrganizationUnit\Requests\OrganizationUnitApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationUnitRequest extends OrganizationUnitApiRequest implements GettableDto
{
    protected array $access = [
        PERMISSIONS => Permissions::CREATE
    ];

    public function rules(): array
    {
        return [
            OrganizationUnit::NAME => $this->getOrganizationUnitNameValidationRules(),
            OrganizationUnit::TYPE => $this->getOrganizationUnitTypeValidationRules(),
            OrganizationUnit::SKU => $this->getOrganizationUnitSkuValidationRules(),
            OrganizationUnit::ORDERING => $this->getOrganizationUnitOrderingValidationRules(),
            'params' => $this->getOrganizationUnitParamsValidationRules(),
            OrganizationUnit::COST_PRICE => $this->getOrganizationUnitCostPriceValidationRules(),
            OrganizationUnit::PRICE_UP => $this->getOrganizationUnitPriceUpValidationRules(),
            OrganizationUnit::CLIENT_PRICE => $this->getOrganizationUnitClientPriceValidationRules(),
            OrganizationUnit::BALANCE => $this->getOrganizationUnitBalanceValidationRules(),
            OrganizationUnit::ORGANIZATION_ID => $this->getOrganizationUnitOrganizationIdValidationRules(),
            OrganizationUnit::SYSTEM_UNIT_ID => $this->getOrganizationUnitSystemUnitIdValidationRules(),
        ];
    }

    /**
     * @return CreateOrganizationUnitDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrganizationUnitDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrganizationUnitDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrganizationUnitDto
    {
        return new CreateOrganizationUnitDto($data);
    }
}
