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

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Counterparty\Countries\Manager as CountryManager;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Containers\OrganizationSection\OwnershipType\Manager as OwnershipTypeManager;
use App\Containers\OrganizationSection\OwnershipType\OooType;
use Illuminate\Testing\Fluent\AssertableJson;

final class RegistrationOrganizationTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/registration';

    public function testRequired(): void
    {
        $this->makeCall();

        $this
            ->assertGivenDataIsInvalid()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors', [
                        Organization::NAME => [
                            Container::trans('validation.name.required')
                        ],
                        Organization::EMAIL => [
                            Container::trans('validation.email.required')
                        ],
                        Organization::OWNER_NAME => [
                            Container::trans('validation.owner_name.required')
                        ],
                        Organization::OWNERSHIP_TYPE => [
                            Container::trans('validation.ownership_type.required')
                        ],
                        User::PASSWORD => [
                            __('validation.custom.password.required')
                        ]
                    ])
                    ->etc()
            );
    }

    public function testWithInvalidEmail(): void
    {
        $this->makeCall([
            Organization::NAME => 'Test Organization',
            Organization::EMAIL => 'ema'
        ]);

        $this
            ->assertGivenDataIsInvalid()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors.' . Organization::EMAIL, [
                        __('validation.custom.email.email')
                    ])
                    ->etc()
            );
    }

    public function testSuccess(): void
    {
        $defaultCountry = CountryManager::getInstance()->get(RuCountry::class);
        $ownershipType = OwnershipTypeManager::getInstance()->get(OooType::class);

        $data = [
            Organization::OWNERSHIP_TYPE => $ownershipType->getName(),
            Organization::NAME => 'Test Organization',
            Organization::EMAIL => 'ivan@test.test',
            Organization::OWNER_NAME => 'Ivanov|Ivan|Ivanovich',
            User::PASSWORD => 25644578
        ];

        $this->makeCall($data);

        $organizationId = $this->getResponseContentObject()->data->id;
        $userOwnerId = $this->getResponseContentObject()->data->user_owner->data->id;

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationModel::RESOURCE_KEY)
                    ->where('data.' . Organization::NAME, $data[Organization::NAME])
                    ->where('data.' . Organization::OWNERSHIP_TYPE . '.name', $data[Organization::OWNERSHIP_TYPE])
                    ->where('data.' . Organization::COUNTRY, $defaultCountry->toArray())
                    ->where('data.' . Organization::EMAIL, $data[Organization::EMAIL])
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::SURNAME, 'Ivanov')
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::NAME, 'Ivan')
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::PATRONYMIC, 'Ivanovich')
                    ->where(
                        'data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::EMAIL,
                        $data[Organization::EMAIL]
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

        /** @var UserModel $userOwner */
        $userOwner = UserModel::find(hash_decode($userOwnerId));

        $this->assertTrue($userOwner->hasRole(RoleModel::ORGANIZATION_OWNER));
    }
}
