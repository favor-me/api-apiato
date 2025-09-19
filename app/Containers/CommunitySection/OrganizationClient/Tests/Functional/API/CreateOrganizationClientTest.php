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

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\Functional\ApiTestCase;
use App\Ship\Utils\Str;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOrganizationClientTest extends ApiTestCase
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
            PERMISSIONS => ''
        ]);

        $this->makeCall($this->testData);

        $this->assertActionIsUnauthorized();
    }

    public function testCantsCreateDouble(): void
    {
        $user = $this->getTestingOrganizationUser();

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $user->organization_id,
                OrganizationClient::PHONE_NUMBER => '+79271231280'
            ]);

        $data = [
            OrganizationClient::SURNAME => 'Ivanov',
            OrganizationClient::NAME => 'Ivan',
            OrganizationClient::PATRONYMIC => 'Ivanovich',
            OrganizationClient::NOTE => 'Test note',
            OrganizationClient::PHONE_NUMBER => $client->phone_number
        ];

        $this->makeCall($data);

        $this->assertGivenDataIsInvalid();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->has('errors')
                ->where('errors.' . OrganizationClient::PHONE_NUMBER, [
                    Container::trans('validation.phone_number.unique')
                ])
                ->etc()
        );
    }

    public function testSuccess(): void
    {
        $user = $this->getTestingOrganizationUser();

        $data = [
            OrganizationClient::SURNAME => 'Ivanov',
            OrganizationClient::NAME => 'Ivan',
            OrganizationClient::PATRONYMIC => 'Ivanovich',
            OrganizationClient::NOTE => 'Test note',
            OrganizationClient::PHONE_NUMBER => '+79271231234'
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationClientModel::RESOURCE_KEY)
                    ->where('data.' . OrganizationClient::SURNAME, $data[OrganizationClient::SURNAME])
                    ->where('data.' . OrganizationClient::NAME, $data[OrganizationClient::NAME])
                    ->where('data.' . OrganizationClient::PATRONYMIC, $data[OrganizationClient::PATRONYMIC])
                    ->where('data.' . OrganizationClient::NOTE, $data[OrganizationClient::NOTE])
                    ->where(
                        'data.' . OrganizationClient::PHONE_NUMBER,
                        (string)Str::toPhoneNumber($data[OrganizationClient::PHONE_NUMBER])
                    )
                    ->where('data.' . OrganizationClient::ORGANIZATION_ID, $user->getHashedKey(User::ORGANIZATION_ID))
                    ->has('meta')
                    ->where('meta.include', [
                        OrganizationClient::INCLUDE_ORGANIZATION
                    ])
                    ->etc()
            );
    }
}
