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

namespace App\Containers\CommunitySection\Organization\Tests\Unit\Models;

use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;

final class OrganizationTest extends UnitTestCase
{
    protected ?OrganizationModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrganizationModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrganizationModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrganizationModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrganizationModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Organization::NAME,
            Organization::INN,
            Organization::PHONE_NUMBER,
            Organization::EMAIL,
            PARAMS
        ], $this->model->getFillable());
    }
}
