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

/**
 * @property-read mixed $country
 * @property-read mixed $ownership_type
 */
class GetCounterpartyBankDataSchemaRequest extends CounterpartyApiRequest
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    protected array $urlParameters = [
        Counterparty::COUNTRY,
        Counterparty::OWNERSHIP_TYPE
    ];

    public function rules(): array
    {
        return [
            Counterparty::COUNTRY => $this->getCounterpartyCountryValidationRules(),
            Counterparty::OWNERSHIP_TYPE => $this->getCounterpartyOwnershipTypeValidationRules()
        ];
    }

    public function getCounterpartyCountryValidationRules(): ValidationRules
    {
        return parent::getCounterpartyCountryValidationRules()
            ->addRequired();
    }

    public function getCounterpartyOwnershipTypeValidationRules(): ValidationRules
    {
        return parent::getCounterpartyOwnershipTypeValidationRules()
            ->addRequired();
    }
}
