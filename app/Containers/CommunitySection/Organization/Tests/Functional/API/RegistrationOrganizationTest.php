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
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\InnElement;
use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Ship\Utils\Str;
use Illuminate\Testing\Fluent\AssertableJson;

final class RegistrationOrganizationTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/registration';

    public function testRequired(): void
    {
        $innElement = new InnElement();

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
                        Organization::PHONE_NUMBER => [
                            Container::trans('validation.phone_number.required')
                        ],
                        Organization::COUNTRY => [
                            Container::trans('validation.country.required')
                        ],
                        Organization::OWNER_NAME => [
                            Container::trans('validation.owner_name.required')
                        ],
                        User::PASSWORD => [
                            __('validation.custom.password.required')
                        ],
                        $innElement->getName() => [
                            $innElement->trans('rules.required')
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

        $this
            ->assertGivenDataIsInvalid()
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
        $inn = new InnElement();
        $country = Manager::getInstance()->get(RuCountry::class);

        $data = [
            Organization::NAME => 'Test Organization',
            Organization::PHONE_NUMBER => '+79272236975',
            Organization::OWNER_NAME => 'Ivanov|Ivan|Ivanovich',
            Organization::COUNTRY => $country->getName(),
            User::PASSWORD => 25644578,
            $inn->getName() => '0123456789'
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
                    ->where('data.' . Organization::COUNTRY, $country->toArray())
                    ->where('data.' . Organization::BANK_DATA, [
                        $inn->getName() => $data[$inn->getName()]
                    ])
                    ->where('data.' . Organization::PHONE_NUMBER, Str::toPhoneNumber($data[Organization::PHONE_NUMBER]))
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::SURNAME, 'Ivanov')
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::NAME, 'Ivan')
                    ->where('data.' . Organization::INCLUDE_USER_OWNER . '.data.' . User::PATRONYMIC, 'Ivanovich')
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

        /** @var UserModel $userOwner */
        $userOwner = UserModel::find(hash_decode($userOwnerId));

        $this->assertTrue($userOwner->hasRole(RoleModel::ORGANIZATION_OWNER));
    }

    public function testRuInnUnique(): void
    {
        $organization = OrganizationModel::factory()
            ->ru()
            ->create();

        $inn = new InnElement();
        $country = Manager::getInstance()->get(RuCountry::class);

        $data = [
            Organization::NAME => 'New Organization',
            Organization::PHONE_NUMBER => '+79272236977',
            Organization::OWNER_NAME => 'Ivanov|Sergey|Sergeevich',
            Organization::COUNTRY => $country->getName(),
            User::PASSWORD => 25644578,
            $inn->getName() => $organization->bank_data->get($inn->getName())
        ];

        $this->makeCall($data);

        $this
            ->assertGivenDataIsInvalid()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('errors')
                    ->where('errors.' . $inn->getName(), [
                        Container::trans('validation.unique_organization')
                    ])
                    ->etc()
            );
    }
}
