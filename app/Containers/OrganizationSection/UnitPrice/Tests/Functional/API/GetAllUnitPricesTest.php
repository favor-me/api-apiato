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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Functional\API;

use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\ContractType;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllUnitPricesTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri('{' . UnitPrice::MODEL_ID . '}');
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = Contract::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        UnitPriceModel::factory()
            ->count(2)
            ->create();

        $models = UnitPriceModel::factory()
            ->count(3)
            ->create([
                UnitPrice::MODEL_ID => $contract->id
            ]);

        $contractType = Manager::getInstance()->get(ContractType::class);

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('meta.pagination.total', $models->count())
                    ->etc()
            );
    }
}
