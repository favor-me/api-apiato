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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Unit\Models;

use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;

final class UnitPriceTest extends UnitTestCase
{
    protected ?UnitPriceModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = UnitPriceModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(UnitPriceModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(UnitPriceModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(UnitPriceModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            UnitPrice::MODEL,
            UnitPrice::MODEL_ID,
            UnitPrice::UNIT_ID,
            UnitPrice::COST_PRICE,
            UnitPrice::PRICE_UP,
            UnitPrice::CLIENT_PRICE
        ], $this->model->getFillable());
    }
}
