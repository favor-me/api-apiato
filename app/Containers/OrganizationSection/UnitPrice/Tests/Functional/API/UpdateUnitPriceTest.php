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
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateUnitPriceTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $uri = Container::getApiUri('{' . UnitPrice::MODEL_ID . '}/{' . UnitPrice::UNIT_ID . '}');
        $this->endpoint = 'patch@v1/' . $uri;
    }

    public function testWithEmptyData(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->injectId(123123, false, '{' . UnitPrice::UNIT_ID . '}')
            ->makeCall();

        $this->response
            ->assertUnprocessable()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.empty_update_data'))
                    ->etc()
            );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->injectId(123123, false, '{' . UnitPrice::UNIT_ID . '}')
            ->makeCall([
                UnitPrice::COST_PRICE => 100
            ]);

        $this
            ->assertGivenDataIsInvalid()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors.' . UnitPrice::UNIT_ID, [
                        __('validation.exists', [
                            'attribute' => 'unit id'
                        ])
                    ])
                    ->etc()
            );
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = ContractModel::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $unit = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $model = UnitPriceModel::factory()
            ->create([
                UnitPrice::MODEL_ID => $contract->id,
                UnitPrice::UNIT_ID => $unit->id
            ]);

        $data = [
            UnitPrice::CLIENT_PRICE => 100,
            UnitPrice::COST_PRICE => 200
        ];

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->injectId($model->unit_id, false, '{' . UnitPrice::UNIT_ID . '}')
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . UnitPrice::COST_PRICE . '.currency.value', $data[UnitPrice::COST_PRICE])
                    ->where('data.' . UnitPrice::CLIENT_PRICE . '.currency.value', $data[UnitPrice::CLIENT_PRICE])
                    ->etc()
            );
    }
}
