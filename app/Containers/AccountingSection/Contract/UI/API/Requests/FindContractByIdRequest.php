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
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Validation\Rules\Exists;

class FindContractByIdRequest extends ContractApiRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
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
        return [
            ID => $this->getContractIdValidationRules()
        ];
    }

    public function getContractIdValidationRules(): ValidationRules
    {
        return parent::getContractIdValidationRules()
            ->addRequired();
    }

    public function getContractIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getContractIdExistsValidationRule($column)
            ->where(Contract::ORGANIZATION_ID, $this->organization_id);
    }
}
