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
use App\Containers\AppSection\User\Traits\IsOrganizationOwner;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Requests\CounterpartyApiRequest;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class RestoreCounterpartiesRequest extends CounterpartyApiRequest
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
            IDS . '.*' => $this->getCounterpartyIdValidationRules()
        ];
    }

    public function getCounterpartyIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getCounterpartyIdExistsValidationRule($column)
            ->where(Counterparty::ORGANIZATION_ID, $this->organization_id)
            ->whereNotNull(DELETED_AT);
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationOwner'
        ]);
    }
}
