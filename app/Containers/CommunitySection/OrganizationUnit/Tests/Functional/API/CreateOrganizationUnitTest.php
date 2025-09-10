<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\Functional\ApiTestCase;
use App\Containers\CommunitySection\OrganizationUnitType\ProductType;
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

        $data = [
            OrganizationUnit::NAME => 'My product',
            OrganizationUnit::TYPE => (new ProductType())->getName(),
            OrganizationUnit::SKU => 'sk-45t',
            OrganizationUnit::ORDERING => 10,
            OrganizationUnit::COST_PRICE => $costPrice,
            OrganizationUnit::PRICE_UP => $priceUp,
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
                    ->where('data.' . OrganizationUnit::TYPE, $data[OrganizationUnit::TYPE])
                    ->where('data.' . OrganizationUnit::SKU, $data[OrganizationUnit::SKU])
                    ->where('data.' . OrganizationUnit::ORDERING, $data[OrganizationUnit::ORDERING])
                    ->where('data.' . OrganizationUnit::PRICE_UP, $data[OrganizationUnit::PRICE_UP])
                    ->where(
                        'data.' . OrganizationUnit::COST_PRICE . '.currency.value',
                        $data[OrganizationUnit::COST_PRICE]
                    )
                    ->where('data.' . OrganizationUnit::CLIENT_PRICE . '.currency.value', $clientPrice)
                    ->etc()
            );
    }

    public function testWithInvalidClientPrice(): void
    {
        $this->getTestingOrganizationUser();

        $costPrice = 100;
        $priceUp = 8;

        $data = [
            OrganizationUnit::NAME => 'My product',
            OrganizationUnit::TYPE => (new ProductType())->getName(),
            OrganizationUnit::COST_PRICE => $costPrice,
            OrganizationUnit::PRICE_UP => $priceUp,
            OrganizationUnit::CLIENT_PRICE => 200
        ];

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . OrganizationUnit::CLIENT_PRICE, [
                    Container::trans('validation.client_price.size', [
                        'size' => app('money')
                            ->addCurrency(108)
                            ->currency()
                            ->text()
                    ])
                ])
                ->etc()
        );
    }
}
