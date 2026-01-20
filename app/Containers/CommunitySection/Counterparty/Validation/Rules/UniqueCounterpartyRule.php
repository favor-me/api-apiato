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

namespace App\Containers\CommunitySection\Counterparty\Validation\Rules;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Validation\Rules\UniqueOrganizationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class UniqueCounterpartyRule extends UniqueOrganizationRule
{
    protected function baseQuery(mixed $value): Builder
    {
        $organizationId = Auth::user()->getAttribute(User::ORGANIZATION_ID);

        return parent::baseQuery($value)
            ->where(Counterparty::ORGANIZATION_ID, $organizationId);
    }

    protected function message(): string
    {
        return Container::trans('container.validation.unique_counterparty');
    }

    protected function getBankDataKey(): string
    {
        return Counterparty::BANK_DATA;
    }

    protected function getCountryKey(): string
    {
        return Counterparty::COUNTRY;
    }

    protected function getTableName(): string
    {
        return CounterpartyModel::TABLE;
    }
}
