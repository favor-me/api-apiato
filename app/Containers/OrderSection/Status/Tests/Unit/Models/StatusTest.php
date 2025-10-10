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

namespace App\Containers\OrderSection\Status\Tests\Unit\Models;

use App\Containers\OrderSection\Status\Facades\Container;
use App\Containers\OrderSection\Status\Tests\UnitTestCase;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;

final class StatusTest extends UnitTestCase
{
    protected ?StatusModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = StatusModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(StatusModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(StatusModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertFalse($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(StatusModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Status::NAME,
            Status::SLUG,
            Status::IS_BASE,
            'params'
        ], $this->model->getFillable());
    }

    public function testName(): void
    {
        $model = StatusModel::factory()
            ->make([
                Status::NAME => 'completed',
                Status::SLUG => 'completed'
            ]);

        $this->assertSame(Container::trans('container.completed'), $model->name);

        $model = StatusModel::factory()
            ->make([
                Status::NAME => 'Test status',
                Status::SLUG => 'test'
            ]);

        $this->assertSame('Test status', $model->name);
    }
}
