<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Requests\OrganizationBranchApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use App\Ship\Utils\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property-read mixed $organization_id
 */
class CreateOrganizationBranchRequest extends OrganizationBranchApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $decode = [
        OrganizationBranch::RESPONSIBLE_BY,
        OrganizationBranch::ORGANIZATION_ID
    ];

    public function messages(): array
    {
        return [
            OrganizationBranch::NAME . '.required' => Container::trans(
                'validation.' . OrganizationBranch::NAME . '.required'
            ),
            OrganizationBranch::PHONE_NUMBER . '.required' => Container::trans(
                'validation.' . OrganizationBranch::PHONE_NUMBER . '.required'
            ),
            OrganizationBranch::LOCATION . '.required' => Container::trans(
                'validation.' . OrganizationBranch::LOCATION . '.required'
            )
        ];
    }

    public function rules(): array
    {
        return [
            OrganizationBranch::NAME => $this->getOrganizationBranchNameValidationRules(),
            OrganizationBranch::PHONE_NUMBER => $this->getOrganizationBranchPhoneNumberValidationRules(),
            OrganizationBranch::LOCATION => $this->getOrganizationBranchLocationValidationRules(),
            OrganizationBranch::LATITUDE => $this->getOrganizationBranchLatitudeValidationRules(),
            OrganizationBranch::LONGITUDE => $this->getOrganizationBranchLongitudeValidationRules(),
            OrganizationBranch::ORGANIZATION_ID => $this->getOrganizationBranchOrganizationIdValidationRules(),
            OrganizationBranch::RESPONSIBLE_BY => $this->getOrganizationBranchResponsibleByValidationRules(),
        ];
    }

    public function getOrganizationBranchResponsibleByValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getUserExistsInOrganizationValidationRule($this->organization_id)
        ])
            ->addRequired();
    }

    public function getOrganizationBranchOrganizationIdValidationRules(): ValidationRules
    {
        return validation_rules([])
            ->addRequired();
    }

    public function getOrganizationBranchLocationValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchLocationValidationRules()
            ->addRequired();
    }

    public function getOrganizationBranchPhoneNumberValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchPhoneNumberValidationRules()
            ->addRequired();
    }

    public function getOrganizationBranchNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationBranchNameValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateOrganizationBranchDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrganizationBranchDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrganizationBranchDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrganizationBranchDto
    {
        return new CreateOrganizationBranchDto($data);
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationPhoneNumber();
        if ($this->user()->isRealOrganizationOwner()) {
            $this->prepareForValidationOrganizationId();
            $this->prepareForValidationResponsibleBy();
        }
    }

    protected function prepareForValidationResponsibleBy(): void
    {
        if (!$this->has(OrganizationBranch::RESPONSIBLE_BY)) {
            $this->merge([
                OrganizationBranch::RESPONSIBLE_BY => $this->user()->getHashedKey()
            ]);
        }
    }

    protected function prepareForValidationOrganizationId(): void
    {
        $this->merge([
            OrganizationBranch::ORGANIZATION_ID => $this->user()->getHashedKey(OrganizationBranch::ORGANIZATION_ID)
        ]);
    }

    protected function prepareForValidationPhoneNumber(): void
    {
        if ($this->has(OrganizationBranch::PHONE_NUMBER)) {
            $this->merge([
                OrganizationBranch::PHONE_NUMBER => Str::toPhoneNumber(
                    $this->get(OrganizationBranch::PHONE_NUMBER)
                )
            ]);
        }
    }
}
