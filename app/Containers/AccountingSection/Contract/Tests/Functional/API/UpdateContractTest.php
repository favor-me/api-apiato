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

use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\AccountingSection\Contract\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateContractTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testWithEmptyData(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $this
            ->injectId(416346)
            ->makeCall();

        $this->response
            ->assertUnprocessable()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, __('ship::exception.message.empty_update_data'))
                    ->etc()
            );
    }

    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $data = [
            Counterparty::NAME => 'New name'
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . ID, [
                    __('validation.custom.id.exists')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $model = ContractModel::factory()
            ->counterparty($this->testingUser->organization_id)
            ->create();

        $data = [
            Counterparty::NAME => 'New name'
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . ID, $model->getHashedKey())
                    ->where('data.' . Contract::NAME, $data[Contract::NAME])
                    ->etc()
            );
    }
}
