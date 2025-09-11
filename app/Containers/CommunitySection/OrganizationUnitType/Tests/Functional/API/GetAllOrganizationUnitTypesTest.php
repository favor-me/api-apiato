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

namespace App\Containers\CommunitySection\OrganizationUnitType\Tests\Functional\API;

use App\Containers\CommunitySection\OrganizationUnitType\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnitType\Tests\Functional\ApiTestCase;
use App\Ship\Requests\ApiRequest;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllOrganizationUnitTypesTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri();
    }

    public function test(): void
    {
        $this->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('data', function (Collection $types) {
                        $types->each(function ($status) {
                            $this->assertSame([
                                'name',
                                'title',
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }

    public function testToList(): void
    {
        $this
            ->endpoint($this->endpoint . '?to=' . ApiRequest::TO_LIST_VALUE)
            ->makeCall();

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->where('data', function (Collection $types) {
                        $types->each(function ($status) {
                            $this->assertSame([
                                'value',
                                'title',
                            ], array_keys($status));
                        });

                        return true;
                    })
                    ->etc()
            );
    }
}
