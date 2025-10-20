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

namespace App\Containers\HistorySection\ModelEvent\Tests\Unit\Foundation;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\HistorySection\ModelEvent\Exceptions\NotFoundModelEventTypeException;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventManager;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;
use App\Containers\HistorySection\ModelEvent\Tests\UnitTestCase;
use Illuminate\Support\Facades\File;

final class ModelEventManagerTest extends UnitTestCase
{
    public function testGetItemAccessor(): void
    {
        $this->assertSame(ModelEventType::class, ModelEventManager::getInstance()->getItemAccessor());
    }

    public function testGetPaths(): void
    {
        $paths = ModelEventManager::getInstance()->getPaths();

        foreach (Apiato::getAllContainerPaths() as $containerPath) {
            $eventTypePath = $containerPath . '/' . ModelEventManager::CONTAINER_EVENT_TYPE_PATH;
            if (File::isDirectory($eventTypePath)) {
                $this->assertTrue(in_array($eventTypePath, $paths));
            }
        }

        $this->assertTrue(true);
    }

    public function testRunWithInvalidEventType(): void
    {
        $this->expectException(NotFoundModelEventTypeException::class);
        ModelEventManager::getInstance()->run('not_found_event_type');
    }
}
