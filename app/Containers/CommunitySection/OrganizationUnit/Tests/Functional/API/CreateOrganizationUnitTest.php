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

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use App\Containers\CommunitySection\OrganizationUnitType\ProductType;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\Vendor\Unit\Models\Unit;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOrganizationUnitTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/' . Container::getApiUri();
    }

    public function testWithoutAccess(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => '',
            ROLES => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $unit = Unit::factory()->create();

        $costPrice = 100;
        $priceUp = 12.2;
        $clientPrice = $costPrice + (($costPrice / 100) * $priceUp);

        $type = new ProductType();

        $data = [
            OrganizationUnit::NAME => 'My product',
            OrganizationUnit::TYPE => $type->getName(),
            OrganizationUnit::SKU => 'sk-45t',
            OrganizationUnit::ORDERING => 10,
            UnitPrice::CLIENT_PRICE => $clientPrice,
            UnitPrice::COST_PRICE => $costPrice,
            OrganizationUnit::SYSTEM_UNIT_ID => $unit->getHashedKey(),
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationUnitModel::RESOURCE_KEY)
                    ->where('data.' . OrganizationUnit::NAME, $data[OrganizationUnit::NAME])
                    ->where('data.' . OrganizationUnit::TYPE, $type->toArray())
                    ->where('data.' . OrganizationUnit::SKU, $data[OrganizationUnit::SKU])
                    ->where('data.' . OrganizationUnit::ORDERING, $data[OrganizationUnit::ORDERING])
                    ->where(
                        'data.' . UnitPrice::COST_PRICE . '.currency.value',
                        $data[UnitPrice::COST_PRICE]
                    )
                    ->where('data.' . UnitPrice::CLIENT_PRICE . '.currency.value', $clientPrice)
                    ->etc()
            );
    }
}
