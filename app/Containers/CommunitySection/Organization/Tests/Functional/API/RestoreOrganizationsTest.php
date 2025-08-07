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
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

final class RestoreOrganizationsTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::READ_ARCHIVE
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'post@v1/restore/' . Container::getApiUri();
    }

    public function testIsUnauthorized(): void
    {
        $this->getTestingUser(null, [
            PERMISSIONS => ''
        ]);

        $this->makeCall();

        $this->assertActionIsUnauthorized();
    }

    public function testWithTrashed(): void
    {
        $models = OrganizationModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->response
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleRestored($models->count()))
                    ->etc()
            );
    }

    public function testWithNotTrashed(): void
    {
        $models = OrganizationModel::factory()
            ->count(2)
            ->create();

        $this->makeCall([
            IDS => $models
                ->getHashedKeys()
                ->toArray()
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors', [
                    IDS . '.0' => [
                        __('validation.custom.ids.*.exists')
                    ],
                    IDS . '.1' => [
                        __('validation.custom.ids.*.exists')
                    ]
                ])
                ->etc()
        );
    }

    public function testWithOneTrashedAndOneIsNotTrashed(): void
    {
        $model = OrganizationModel::factory()->create();

        $modelTrashed = OrganizationModel::factory()
            ->trashed()
            ->create();

        $this->makeCall([
            IDS => [
                $model->getHashedKey(),
                $modelTrashed->getHashedKey()
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
}
