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
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\ContractType;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteUnitPricesTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri('{' . UnitPrice::MODEL_ID . '}');
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = Contract::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $unitPrice = UnitPriceModel::factory()->create();
        $contractType = Manager::getInstance()->get(ContractType::class);

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->makeCall([
                UnitPrice::UNIT_IDS => [
                    $unitPrice->getHashedKey()
                ]
            ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    UnitPrice::UNIT_IDS . '.0' => [
                        __('validation.exists', [
                            'attribute' => UnitPrice::UNIT_IDS . '.0'
                        ])
                    ]
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $contract = Contract::factory()
            ->counterparty(
                $this->testingUser->organization_id
            )
            ->create();

        $contractType = Manager::getInstance()->get(ContractType::class);

        $organizationUnitA = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $modelA = UnitPriceModel::factory()
            ->create([
                UnitPrice::MODEL_ID => $contract->id,
                UnitPrice::UNIT_ID => $organizationUnitA->id
            ]);

        $organizationUnitB = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::ORGANIZATION_ID => $this->testingUser->organization_id
            ]);

        $modelB = UnitPriceModel::factory()
            ->create([
                UnitPrice::MODEL_ID => $contract->id,
                UnitPrice::UNIT_ID => $organizationUnitB->id
            ]);

        $this
            ->injectId($contractType->getModelKey(), true, '{' . UnitPrice::MODEL . '}')
            ->injectId($contract->id, false, '{' . UnitPrice::MODEL_ID . '}')
            ->makeCall([
                UnitPrice::UNIT_IDS => [
                    $modelA->getHashedKey(),
                    $modelB->getHashedKey()
                ]
            ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleDeleted(2))
                    ->etc()
            );
    }
}
