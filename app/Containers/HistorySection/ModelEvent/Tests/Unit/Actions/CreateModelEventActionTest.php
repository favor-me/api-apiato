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

namespace App\Containers\HistorySection\ModelEvent\Tests\Unit\Actions;

use App\Containers\HistorySection\ModelEvent\Actions\CreateModelEventAction;
use App\Containers\HistorySection\ModelEvent\Dto\CreateModelEventDto;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Tests\UnitTestCase;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

final class CreateModelEventActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $dto = new CreateModelEventDto([
            BaseModelEvent::TYPE => 'create_test_event',
            BaseModelEvent::MODEL => ModelEvent::class,
            BaseModelEvent::MODEL_ID => 123,
            BaseModelEvent::DATA => [],
            BaseModelEvent::DATA_CHANGES => [
                'value' => 'Test'
            ]
        ]);

        $result = app(CreateModelEventAction::class)->run($dto);

        $this->assertInstanceOf(ModelEvent::class, $result);
        $this->assertSame($dto->type, $result->type);
        $this->assertInstanceOf(JSON::class, $result->data);
        $this->assertInstanceOf(JSON::class, $result->data_changes);
        $this->assertSame('Test', $result->data_changes->get('value'));
        $this->assertInstanceOf(Carbon::class, $result->created_at);
        $this->assertInstanceOf(Carbon::class, $result->updated_at);
    }
}
