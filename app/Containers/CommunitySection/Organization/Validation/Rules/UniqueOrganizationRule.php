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

use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Ship\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\DB;

class UniqueOrganizationRule extends ValidationRule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $countryVal = $this->data->get(Organization::COUNTRY);
        $country = Manager::getInstance()->get($countryVal);

        $exists = DB::table(OrganizationModel::TABLE)
            ->whereJsonContains(Organization::BANK_DATA, [
                $country->getUniqueElement()->getName() => $value
            ])
            ->exists();

        if ($exists) {
            $fail(Container::trans('validation.unique_organization'));
        }
    }
}
