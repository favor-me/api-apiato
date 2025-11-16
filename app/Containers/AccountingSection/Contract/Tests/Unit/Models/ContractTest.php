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

namespace App\Containers\AccountingSection\Contract\Tests\Unit\Models;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\UnitTestCase;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ContractTest extends UnitTestCase
{
    protected ?ContractModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = ContractModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(ContractModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(ContractModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(ContractModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Contract::NAME,
            Contract::NUMBER,
            Contract::COUNTERPARTY_ID,
            Contract::ORGANIZATION_ID,
            Contract::START_AT,
            Contract::FINISH_AT
        ], $this->model->getFillable());
    }

    public function testBelongsToCounterparty(): void
    {
        $this->getTestingOrganizationUser();

        $contract = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $contract->counterparty());
        $this->assertInstanceOf(Counterparty::class, $contract->counterparty()->getModel());
        $this->assertInstanceOf(Counterparty::class, $contract->counterparty);
        $this->assertSame($contract->counterparty_id, $contract->counterparty->id);
    }

    public function testBelongsToOrganization(): void
    {
        $this->getTestingOrganizationUser();

        $contract = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $contract->organization());
        $this->assertInstanceOf(Organization::class, $contract->organization()->getModel());
        $this->assertInstanceOf(Organization::class, $contract->organization);
        $this->assertSame($contract->organization_id, $contract->organization->id);
    }
}
