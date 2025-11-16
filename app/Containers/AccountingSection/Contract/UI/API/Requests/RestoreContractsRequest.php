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

namespace App\Containers\AccountingSection\Contract\UI\API\Requests;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Requests\ContractApiRequest;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class RestoreContractsRequest extends ContractApiRequest
{
    use HasInputIds;
    use IsOrganizationOwner;

    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(IDS . '.*');
    }

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getContractIdValidationRules()
        ];
    }

    public function getContractIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getContractIdExistsValidationRule($column)
            ->where(Contract::ORGANIZATION_ID, $this->organization_id)
            ->whereNotNull(DELETED_AT);
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
