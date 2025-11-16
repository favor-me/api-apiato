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

namespace App\Containers\AccountingSection\Contract\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\Functional\ApiTestCase;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Ship\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateContractTest extends ApiTestCase
{
    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
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
            ROLES => '',
            PERMISSIONS => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationUser();

        $counterparty = CounterpartyModel::factory()
            ->rus()
            ->organization($this->testingUser->organization_id)
            ->create();

        $now = Carbon::now();
        $tomorrow = Carbon::tomorrow();

        $data = [
            Contract::NAME => 'Test',
            Contract::COUNTERPARTY_ID => $counterparty->getHashedKey(),
            Contract::START_AT => $now->toSystemDateString(),
            Contract::FINISH_AT => $tomorrow->toSystemDateString()
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, ContractModel::RESOURCE_KEY)
                    ->where('data.' . Contract::NAME, $data[Contract::NAME])
                    ->where('data.' . Contract::COUNTERPARTY_ID, $counterparty->getHashedKey())
                    ->where('data.' . Contract::COUNTERPARTY . '.data.id', $counterparty->getHashedKey())
                    ->where('data.' . Contract::START_AT . '.date_for_human', $now->toSystemDateString())
                    ->where('data.' . Contract::FINISH_AT . '.date_for_human', $tomorrow->toSystemDateString())
                    ->etc()
            );
    }
}
