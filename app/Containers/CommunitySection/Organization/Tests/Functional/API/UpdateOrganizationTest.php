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
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateOrganizationTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::UPDATE
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('{' . ID . '}');
    }

    public function testWithEmptyData(): void
    {
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
        $data = [
            // Write here
        ];

        $this
            ->injectId(123123)
            ->makeCall($data);

        $this->assertGivenDataWasInvalid();

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
        $model = OrganizationModel::factory()->create();

        $data = [
            // Write here
        ];

        $this
            ->injectId($model->id)
            ->makeCall($data);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    //->where('data.' . , $data[])
                    ->etc()
            );
    }
}
