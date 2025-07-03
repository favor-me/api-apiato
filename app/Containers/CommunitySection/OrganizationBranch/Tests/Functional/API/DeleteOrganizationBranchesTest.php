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

namespace App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\Functional\ApiTestCase;
use App\Ship\Parents\Requests\Request;
use Illuminate\Testing\Fluent\AssertableJson;

final class DeleteOrganizationBranchesTest extends ApiTestCase
{
    protected array $access = [
        ROLES => RoleModel::ADMIN
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri() . '?' . Request::FORCE_DELETE . '=1';
    }

    public function testWithNotTrashed(): void
    {
        $models = OrganizationBranchModel::factory()->create();

        $this->makeCall([
            IDS => [
                $models->getHashedKey()
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->makeCall([
            IDS => [
                hash_encode(123)
            ]
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $models = OrganizationBranchModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $this->makeCall([
            IDS => $models->getIds()
        ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleDeleted($models->count()))
                    ->etc()
            );
    }
}
