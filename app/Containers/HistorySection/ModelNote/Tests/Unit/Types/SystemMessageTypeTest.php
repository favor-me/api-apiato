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

use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Facades\Container;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Containers\HistorySection\ModelNote\Tests\TestCase;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteTypeManager;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;

final class SystemMessageTypeTest extends TestCase
{
    protected ?SystemMessageModelNoteType $type;

    public function setUp(): void
    {
        parent::setUp();
        $this->type = ModelNoteTypeManager::getInstance()->get(SystemMessageModelNoteType::class);
    }

    public function testGetName(): void
    {
        $this->assertSame('system_message', $this->type->getName());
    }

    public function testSave(): void
    {
        $event = ModelEvent::factory()->create();

        $result = $this->type->create($event, [
            'message' => 'User event message',
            'not_allowed' => 'Test info'
        ]);

        $this->assertSame($this->type->getAllowedParamKeys(), array_keys($result->params->getArrayCopy()));

        $this->assertDatabaseHas(ModelNote::TABLE, [
            'id' => $result->id
        ]);
    }

    public function testGetAllowedParamKeys(): void
    {
        $this->assertSame([$this->type::PARAM_KEY_MESSAGE], $this->type->getAllowedParamKeys());
    }

    public function testFactoryParamsDefinition(): void
    {
        $expected = [
            $this->type::PARAM_KEY_MESSAGE => Container::trans('container.factory_default_message')
        ];

        $this->assertSame($expected, $this->type->factoryParamsDefinition());

        $this->assertSame($expected, $this->type->factoryParamsDefinition([
            'custom' => 'Custom param'
        ]));
    }

    public function testGetTitle(): void
    {
        $this->assertSame(Container::trans('container.types.system_message.title'), $this->type->getTitle());
    }

    public function testToArray(): void
    {
        $this->assertSame([
            $this->type::NAME => 'system_message',
            $this->type::TITLE => Container::trans('container.types.system_message.title')
        ], $this->type->toArray());
    }
}
