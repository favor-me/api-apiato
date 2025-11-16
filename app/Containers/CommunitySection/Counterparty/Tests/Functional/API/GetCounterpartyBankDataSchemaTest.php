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

namespace App\Containers\CommunitySection\Counterparty\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetCounterpartyBankDataSchemaTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri('{' . Counterparty::COUNTRY . '}/bank-data-schema');
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $this
            ->injectId(
                (new RuCountry())
                    ->getName()
            )
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->etc()
            );
    }

    public function testFailedCountry(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $this
            ->injectId('ggg')
            ->makeCall();

        $this->assertGivenDataIsInvalid();

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors', 1)
                    ->has('errors.country')
                    ->etc()
            );
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function injectId(
        $id,
        bool $skipEncoding = true,
        string $replace = '{' . Counterparty::COUNTRY . '}'
    ): static {
        return parent::injectId($id, $skipEncoding, $replace);
    }
}
