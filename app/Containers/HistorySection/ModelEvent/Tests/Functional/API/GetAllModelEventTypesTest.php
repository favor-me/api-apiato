<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelEvent\Tests\Functional\API;

use App\Containers\HistorySection\ModelEvent\Facades\Container;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Tests\Functional\ApiTestCase;
use App\Containers\HistorySection\ModelEvent\UI\API\Transformers\ModelEventTypeTransformer;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;

final class GetAllModelEventTypesTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'get@v1/' . Container::getApiUri(BaseModelEvent::API_URI_ALL_TYPES);
    }

    public function test(): void
    {
        $this->makeCall();

        $this->response->assertOk();

        $this->response->assertJson(
            fn(AssertableJson $json): AssertableJson => $json
                ->where('data', function (Collection $modelEvents) {
                    $modelEvents->each(function ($event) {
                        $this->assertSame([
                            ModelEventTypeTransformer::NAME,
                            ModelEventTypeTransformer::TYPE,
                            ModelEventTypeTransformer::GROUP
                        ], array_keys($event));
                    });

                    return true;
                })
                ->etc()
        );
    }
}
