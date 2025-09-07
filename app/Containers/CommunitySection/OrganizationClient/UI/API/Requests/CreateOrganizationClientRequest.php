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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationClient\Dto\CreateOrganizationClientDto;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Requests\OrganizationClientApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationClientRequest extends OrganizationClientApiRequest implements GettableDto
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function rules(): array
    {
        return [
            OrganizationClient::ORGANIZATION_ID => $this->getOrganizationClientOrganizationIdValidationRules(),
            OrganizationClient::NAME => $this->getOrganizationClientNameValidationRules(),
            OrganizationClient::PATRONYMIC => $this->getOrganizationClientPatronymicValidationRules(),
            OrganizationClient::SURNAME => $this->getOrganizationClientSurnameValidationRules(),
            OrganizationClient::PHONE_NUMBER => $this->getOrganizationClientPhoneNumberValidationRules(),
            OrganizationClient::NOTE => $this->getOrganizationClientNoteValidationRules(),
        ];
    }

    public function getOrganizationClientNameValidationRules(): ValidationRules
    {
        return parent::getOrganizationClientNameValidationRules()
            ->addRequired();
    }

    /**
     * @return CreateOrganizationClientDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateOrganizationClientDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateOrganizationClientDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateOrganizationClientDto
    {
        return new CreateOrganizationClientDto($data);
    }
}
