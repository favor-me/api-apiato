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

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Unit\Models;

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class OrganizationClientTest extends UnitTestCase
{
    protected ?OrganizationClientModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrganizationClientModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrganizationClientModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrganizationClientModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrganizationClientModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            OrganizationClient::ORGANIZATION_ID,
            OrganizationClient::NAME,
            OrganizationClient::PATRONYMIC,
            OrganizationClient::SURNAME,
            OrganizationClient::PHONE_NUMBER,
            OrganizationClient::NOTE
        ], $this->model->getFillable());
    }

    public function testBelongsToOrganization(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->organization());
        $this->assertInstanceOf(OrganizationModel::class, $this->model->organization()->getModel());
        $this->assertInstanceOf(OrganizationModel::class, $this->model->organization);
    }
}
