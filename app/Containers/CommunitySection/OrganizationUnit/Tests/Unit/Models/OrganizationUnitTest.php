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

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Unit\Models;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tasks\PlusOrganizationUnitBalanceTask;
use App\Containers\CommunitySection\OrganizationUnit\Tests\UnitTestCase;
use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\ServiceType;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\Vendor\Unit\Models\Unit;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JBZoo\Data\JSON;

final class OrganizationUnitTest extends UnitTestCase
{
    protected ?OrganizationUnitModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrganizationUnitModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrganizationUnitModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrganizationUnitModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrganizationUnitModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            PARAMS,
            OrganizationUnit::NAME,
            OrganizationUnit::TYPE,
            OrganizationUnit::SKU,
            OrganizationUnit::ORDERING,
            UnitPrice::COST_PRICE,
            UnitPrice::PRICE_UP,
            UnitPrice::CLIENT_PRICE,
            UnitPrice::BALANCE,
            UnitPrice::IS_INFINITY_BALANCE,
            OrganizationUnit::ORGANIZATION_ID,
            OrganizationUnit::SYSTEM_UNIT_ID
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Type::class, $this->model->type);
        $this->assertInstanceOf(Money::class, $this->model->cost_price);
        $this->assertInstanceOf(Money::class, $this->model->client_price);
        $this->assertInstanceOf(JSON::class, $this->model->params);
    }

    public function testBelongsToSystemUnit(): void
    {
        $systemUnit = Unit::factory()->create();

        $unit = OrganizationUnitModel::factory()
            ->make([
                OrganizationUnit::SYSTEM_UNIT_ID => $systemUnit->id
            ]);

        $this->assertInstanceOf(BelongsTo::class, $unit->systemUnit());
        $this->assertInstanceOf(Unit::class, $unit->systemUnit()->getModel());
        $this->assertInstanceOf(Unit::class, $unit->systemUnit);
        $this->assertSame($systemUnit->id, $unit->systemUnit->id);
    }

    public function testAttributeType(): void
    {
        $this->assertInstanceOf(Type::class, $this->model->type);
    }

    public function testHasManyModelNotes(): void
    {
        $model = OrganizationUnitModel::factory()->create();

        app(PlusOrganizationUnitBalanceTask::class)->run($model, 11);

        $model->refresh();

        $this->assertInstanceOf(HasMany::class, $model->modelNotes());
        $this->assertInstanceOf(ModelNoteModel::class, $model->modelNotes()->getModel());
        $this->assertInstanceOf(Collection::class, $model->modelNotes);
        $this->assertCount(1, $model->modelNotes);
    }

    public function testSetInfinityBalanceForServiceType(): void
    {
        $serviceTypeName = Manager::getInstance()
            ->get(ServiceType::class)
            ->getName();

        $model = OrganizationUnitModel::factory()
            ->create([
                OrganizationUnit::TYPE => $serviceTypeName
            ]);

        $this->assertTrue($model->is_infinity_balance);
    }

    public function testHasManyContractPriceList(): void
    {
        $this->assertInstanceOf(Collection::class, $this->model->contractPriceList);
        $this->assertInstanceOf(HasMany::class, $this->model->contractPriceList());
    }
}
