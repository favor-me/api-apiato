<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Tests\Unit\Dto;

use App\Ship\Tests\Fackes\Dto\TestPropertiesDto;
use App\Ship\Tests\UnitTestCase;

class DtoTest extends UnitTestCase
{
    public function testProperties()
    {
        $dto = new TestPropertiesDto([
            'name' => 'Test'
        ]);

        $this->assertSame(['name' => 'Test'], $dto->toArray(true));

        $this->assertSame([
            'name' => 'Test',
            'published' => false,
            'sorted' => 0,
            'params' => []
        ], $dto->toArray());
    }

    public function testSet(): void
    {
        $dto = new TestPropertiesDto(['published' => true]);
        $dto->set('name', 'Tester');

        $this->assertSame('Tester', $dto->name);
        $this->assertSame('Tester', $dto->toArray()['name']);
        $this->assertSame('Tester', $dto->toArray(true)['name']);
    }

    public function testExists(): void
    {
        $dto = new TestPropertiesDto(['published' => true]);
        $this->assertTrue($dto->exists('published'));
        $this->assertFalse($dto->exists('same'));
    }

    public function testGet(): void
    {
        $dto = new TestPropertiesDto([
            'published' => true,
            'name' => 'Sergey'
        ]);

        $this->assertSame('Sergey', $dto->get('name'));
        $this->assertTrue($dto->get('published'));
        $this->assertNull($dto->get('same'));
    }

    public function testToArray(): void
    {
        $dto = new TestPropertiesDto([
            'name' => 'Sergey'
        ]);

        $this->assertSame([
            'name' => 'Sergey',
            'published' => false,
            'sorted' => 0,
            'params' => []
        ], $dto->toArray());

        $this->assertSame([
            'name' => 'Sergey'
        ], $dto->toArray(true));
    }

    public function testGetArrayWithExceptKeys(): void
    {
        $dto = new TestPropertiesDto([
            'name' => 'Sergey',
            'published' => false
        ]);

        $this->assertSame([
            'name' => 'Sergey',
            'published' => false
        ], $dto->toArray(true));

        $this->assertSame([
            'name' => 'Sergey'
        ], $dto->except('published')->toArray(true));
    }
}
