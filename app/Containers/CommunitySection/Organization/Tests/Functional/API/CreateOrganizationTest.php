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

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Containers\CommunitySection\Organization\Tests\Functional\ApiTestCase;
use App\Ship\Utils\Str;
use Illuminate\Testing\Fluent\AssertableJson;

final class CreateOrganizationTest extends ApiTestCase
{
    protected array $access = [
        PERMISSIONS => Permissions::CREATE
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

    public function testSuccess(): void
    {
        $user = UserModel::factory()->create();

        $data = [
            Organization::NAME => 'Test Organization',
            Organization::PHONE_NUMBER => '+79272236975',
            Organization::USER_OWNER_ID => $user->getHashedKey()
        ];

        $this->makeCall($data);

        $this->response
            ->assertCreated()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data')
                    ->where('data.' . OBJECT, OrganizationModel::RESOURCE_KEY)
                    ->where('data.' . Organization::NAME, $data[Organization::NAME])
                    ->where('data.' . Organization::PHONE_NUMBER, Str::toPhoneNumber($data[Organization::PHONE_NUMBER]))
                    ->where('data.' . Organization::USER_OWNER_ID, $data[Organization::USER_OWNER_ID])
                    ->etc()
            );
    }
}
