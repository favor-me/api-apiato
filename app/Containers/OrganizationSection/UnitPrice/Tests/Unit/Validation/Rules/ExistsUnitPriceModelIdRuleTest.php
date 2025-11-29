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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Unit\Validation\Rules;

use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\ContractType;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use App\Containers\OrganizationSection\UnitPrice\Validation\Rules\ExistsUnitPriceModelIdRule;

final class ExistsUnitPriceModelIdRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $organization = Organization::factory()->create();

        $contract = Contract::factory()
            ->counterparty($organization->id)
            ->create();

        $rule = new ExistsUnitPriceModelIdRule();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $rule->setData([
            UnitPrice::MODEL => $contractType->getModelKey()
        ]);

        $rule->validate(UnitPrice::MODEL_ID, $contract->id, function (string $message) use ($contractType) {
            $this->assertSame(
                Container::trans('container.' . $contractType->getModelKey() . '.no_exists_model_id'),
                $message
            );
        });
    }
}
