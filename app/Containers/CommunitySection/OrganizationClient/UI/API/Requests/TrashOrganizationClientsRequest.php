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
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Requests\OrganizationClientApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class TrashOrganizationClientsRequest extends OrganizationClientApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected array $decode = [
        IDS . '.*',
        OrganizationClient::ORGANIZATION_ID
    ];

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getOrganizationClientIdValidationRules(),
            OrganizationClient::ORGANIZATION_ID => $this->getOrganizationClientOrganizationIdValidationRules()
        ];
    }

    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationClientIdValidationRules()
            ->addRequired();
    }

    public function getOrganizationClientIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrganizationClientIdExistsValidationRule($column)
            ->where(OrganizationClient::ORGANIZATION_ID, $this->organization_id);
    }
}
