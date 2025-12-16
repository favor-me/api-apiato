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

namespace App\Containers\CommunitySection\Counterparty\Tests\Unit\Models;

use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JBZoo\Data\JSON;

final class CounterpartyTest extends UnitTestCase
{
    protected ?CounterpartyModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = CounterpartyModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(CounterpartyModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(CounterpartyModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(CounterpartyModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Counterparty::NAME,
            Counterparty::LEGAL_ADDRESS,
            Counterparty::MAILING_ADDRESS,
            Counterparty::PHONE_NUMBER,
            Counterparty::EMAIL,
            Counterparty::COUNTRY,
            Counterparty::BANK_DATA,
            Counterparty::ORGANIZATION_ID,
            Counterparty::OWNERSHIP_TYPE
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Country::class, $this->model->country);
        $this->assertInstanceOf(JSON::class, $this->model->bank_data);
        $this->assertIsInt($this->model->phone_number);
    }

    public function testBelongsToOrganization(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->organization());
        $this->assertInstanceOf(Organization::class, $this->model->organization()->getModel());
        $this->assertInstanceOf(Organization::class, $this->model->organization);
    }
}
