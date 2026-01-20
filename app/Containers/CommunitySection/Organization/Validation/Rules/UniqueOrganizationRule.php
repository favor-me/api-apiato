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

namespace App\Containers\CommunitySection\Organization\Validation\Rules;

use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Validation\ValidationRule;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UniqueOrganizationRule extends ValidationRule
{
    public function __construct(
        protected ?int $ignoreValue = null
    ) {
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = $this->baseQuery($value);

        if ($this->ignoreValue !== null) {
            $query->where(ID, '<>', $this->ignoreValue);
        }

        $exists = $query->exists();

        if ($exists) {
            $fail(Container::trans('validation.unique_organization'));
        }
    }

    /**
     * @param mixed $value
     * @return Builder
     */
    protected function baseQuery(mixed $value): Builder
    {
        $country = $this->getCountry();
        return DB::table($this->getTableName())
            ->whereJsonContains($this->getBankDataKey(), [
                $country->getUniqueElement()->getName() => $value
            ]);
    }

    protected function getBankDataKey(): string
    {
        return Organization::BANK_DATA;
    }

    protected function getTableName(): string
    {
        return OrganizationModel::TABLE;
    }

    protected function getCountry(): ?Country
    {
        return Manager::getInstance()
            ->get(
                $this->data->get(Organization::COUNTRY)
            );
    }
}
