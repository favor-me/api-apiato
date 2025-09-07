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
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Ship\Requests\ApiRestoreRequest;
use Illuminate\Validation\Rules\Exists;

/**
 * @property-read mixed $organization_id
 */
class RestoreOrganizationClientsRequest extends ApiRestoreRequest
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(OrganizationClient::ORGANIZATION_ID);
    }

    public function getTableName(): string
    {
        return OrganizationClientModel::TABLE;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareOrganizationIdForValidation();
    }

    protected function prepareOrganizationIdForValidation(): void
    {
        $this->merge([
            OrganizationClient::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
    }

    protected function existsRule(): Exists
    {
        return parent::existsRule()
            ->where(OrganizationClient::ORGANIZATION_ID, $this->organization_id);
    }
}
