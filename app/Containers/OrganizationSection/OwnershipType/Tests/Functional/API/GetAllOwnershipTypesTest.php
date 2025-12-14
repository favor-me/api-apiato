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

namespace App\Containers\OrganizationSection\OwnershipType\Tests\Functional\API;

use App\Containers\OrganizationSection\OwnershipType\Facades\Container;
use App\Containers\OrganizationSection\OwnershipType\Manager;
use App\Containers\OrganizationSection\OwnershipType\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOwnershipTypesTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function testSuccess(): void
    {
        $this->makeCall();

        $total = Manager::getInstance()
            ->all()
            ->count();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has('data', $total)
                    ->etc()
            );
    }
}
