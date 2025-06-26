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

namespace App\Containers\CommunitySection\Organization\Tests\Functional\API;

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class TrashOrganizationsTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::TRASH
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'delete@v1/' . Container::getApiUri();
    }

    public function testFailedWithNoExistsIds(): void
    {
        $this->makeCall([
            IDS => [
                getHashedValue(123)
            ]
        ]);

        $this->assertGivenDataWasInvalid();

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
        $models = OrganizationModel::factory()
            ->count(4)
            ->create();

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleTrashed($models->count()))
                    ->etc()
            );
    }
}
