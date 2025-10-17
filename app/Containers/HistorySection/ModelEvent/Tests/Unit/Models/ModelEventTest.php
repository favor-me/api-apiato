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

namespace App\Containers\HistorySection\ModelEvent\Tests\Unit\Models;

use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Tests\UnitTestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ModelEventTest extends UnitTestCase
{
    public function testBelongsToModelObject(): void
    {
        $event = ModelEvent::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $event->modelObject());
        $this->assertSame($event->model, $event->modelObject::class);
        $this->assertSame($event->model_id, $event->modelObject->getAttribute(ID));
    }
}
