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

namespace App\Containers\CommunitySection\OrganizationBranch\Tests\Unit\Models;

use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;

final class OrganizationBranchTest extends UnitTestCase
{
    protected ?OrganizationBranchModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrganizationBranchModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrganizationBranchModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrganizationBranchModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrganizationBranchModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            OrganizationBranch::NAME,
            OrganizationBranch::PHONE_NUMBER,
            OrganizationBranch::LOCATION,
            OrganizationBranch::LATITUDE,
            OrganizationBranch::LONGITUDE,
            OrganizationBranch::ORGANIZATION_ID,
            OrganizationBranch::RESPONSIBLE_BY
        ], $this->model->getFillable());
    }
}
