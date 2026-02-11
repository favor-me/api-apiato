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

namespace App\Containers\OrganizationSection\Shift\Tests\Unit\Models;

use App\Containers\OrganizationSection\Shift\Tests\UnitTestCase;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;

final class ShiftTest extends UnitTestCase
{
    protected ?ShiftModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = ShiftModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(ShiftModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(ShiftModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(ShiftModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Shift::ORGANIZATION_ID,
            Shift::START_AT,
            Shift::FINISH_AT,
            'created_by'
        ], $this->model->getFillable());
    }
}
