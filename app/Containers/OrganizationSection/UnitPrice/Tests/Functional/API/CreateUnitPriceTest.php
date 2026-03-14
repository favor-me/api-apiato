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

use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\ContractType;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateUnitPriceTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testWithoutAccess(): void
    {
        $this->getTestingUser(null, [
            ROLES => '',
            PERMISSIONS => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $unit = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $data = [
            UnitPrice::MODEL_ID => $contract->getHashedKey(),
            UnitPrice::UNIT_ID => $unit->getHashedKey(),
            UnitPrice::COST_PRICE => 100,
            UnitPrice::CLIENT_PRICE => 110
        ];

        $this
            ->injectId($contractType->getModelKey())
            ->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationUnitModel::RESOURCE_KEY)
                    ->where('data.' . ID, $data[UnitPrice::UNIT_ID])
                    ->where('data.' . UnitPrice::COST_PRICE . '.currency.value', $data[UnitPrice::COST_PRICE])
                    ->where('data.' . UnitPrice::CLIENT_PRICE . '.currency.value', $data[UnitPrice::CLIENT_PRICE])
                    ->etc()
            );
    }

    public function injectId($id, bool $skipEncoding = true, string $replace = '{' . UnitPrice::MODEL . '}'): static
    {
        return parent::injectId($id, $skipEncoding, $replace);
    }
}
