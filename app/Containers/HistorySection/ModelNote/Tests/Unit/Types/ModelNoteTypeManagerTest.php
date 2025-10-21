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

namespace App\Containers\HistorySection\ModelNote\Tests\Unit\Types;

use App\Containers\HistorySection\ModelNote\Tests\UnitTestCase;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteTypeManager;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;

final class ModelNoteTypeManagerTest extends UnitTestCase
{
    public function testGet(): void
    {
        $manager = ModelNoteTypeManager::getInstance();

        $this->assertInstanceOf(
            SystemMessageModelNoteType::class,
            $manager->get('system_message')
        );

        $this->assertInstanceOf(
            SystemMessageModelNoteType::class,
            $manager->get(SystemMessageModelNoteType::class)
        );

        $this->assertNull($manager->get('failed'));
    }
}
