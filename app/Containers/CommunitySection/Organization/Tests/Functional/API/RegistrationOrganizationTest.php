<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\Organization\Tests\Functional\API;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Ship\Utils\Str;
use Illuminate\Testing\Fluent\AssertableJson;

final class RegistrationOrganizationTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/registration';

    public function testRequired(): void
    {
        $this->makeCall();

        $this->assertGivenDataIsInvalid();

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors', [
                        Organization::NAME => [
                            Container::trans('validation.name.required')
                        ],
                        Organization::PHONE_NUMBER => [
                            Container::trans('validation.phone_number.required')
                        ],
                        Organization::OWNER_NAME => [
                            Container::trans('validation.owner_name.required')
                        ],
                        User::PASSWORD => [
                            __('validation.custom.password.required')
                        ]
                    ])
                    ->etc()
            );
    }

    public function testWithInvalidPhoneNumber(): void
    {
        $this->makeCall([
            Organization::NAME => 'Test Organization',
            Organization::PHONE_NUMBER => 7927
        ]);

        $this->assertGivenDataIsInvalid();

        $this->response
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors.' . Organization::PHONE_NUMBER, [
                        __('validation.phone.real_number')
                    ])
                    ->etc()
            );
    }

    public function testSuccess(): void
    {
        $data = [
            Organization::NAME => 'Test Organization',
            Organization::PHONE_NUMBER => '+79272236975',
            Organization::OWNER_NAME => 'Ivanov Ivan',
            User::PASSWORD => 25644578
        ];

        $this->makeCall($data);

        $organizationId = $this->getResponseContentObject()->data->id;

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationModel::RESOURCE_KEY)
                    ->where('data.' . Organization::NAME, $data[Organization::NAME])
                    ->where('data.' . Organization::INN, null)
                    ->where('data.' . Organization::PHONE_NUMBER, Str::toPhoneNumber($data[Organization::PHONE_NUMBER]))
                    ->where(
                        'data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::NAME,
                        $data[Organization::OWNER_NAME]
                    )
                    ->where(
                        'data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::PHONE_NUMBER,
                        Str::toPhoneNumber($data[Organization::PHONE_NUMBER])
                    )
                    ->where(
                        'data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::ORGANIZATION_ID,
                        $organizationId
                    )
                    ->where(
                        'data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::IS_ORGANIZATION_OWNER,
                        true
                    )
                    ->etc()
            );
    }
}
