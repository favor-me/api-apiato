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

namespace App\Containers\CommunitySection\Counterparty\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Requests\CounterpartyApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Validation\Rules\Exists;

class FindCounterpartyByIdRequest extends CounterpartyApiRequest
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
            ID => $this->getCounterpartyIdValidationRules()
        ];
    }

    public function getCounterpartyIdValidationRules(): ValidationRules
    {
        return parent::getCounterpartyIdValidationRules()
            ->addRequired();
    }

    public function getCounterpartyIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getCounterpartyIdExistsValidationRule($column)
            ->where(Counterparty::ORGANIZATION_ID, $this->organization_id);
    }
}
