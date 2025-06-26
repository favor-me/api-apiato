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

namespace App\Ship\Tests\Unit\Transformers;

use App\Ship\Tests\Fackes\Transformers\TestTransformer;
use App\Ship\Tests\UnitTestCase;
use stdClass;

class TransformerTest extends UnitTestCase
{
    public function testNullOrItemIsItem(): void
    {
        $data = new stdClass();
        $data->description = 'Test description';
        $testAnonymousTransformer = new TestTransformer();
        $resource = $testAnonymousTransformer->nullOrItem($data, new TestTransformer(), 777);
        $this->assertIsObject($resource);
        $this->assertIsObject($resource->getData());
        $this->assertSame($data->description, $resource->getData()->description);
    }

    public function testNullOrItemIsNull(): void
    {
        $testAnonymousTransformer = new TestTransformer();
        $resource = $testAnonymousTransformer->nullOrItem(null, new TestTransformer());
        $this->assertIsObject($resource);
        $this->assertNull($resource->getData());
    }

    public function testAddDefaultIncludes(): void
    {
        $transformer = new TestTransformer();

        $this->assertSame([], $transformer->getDefaultIncludes());

        $transformer->addDefaultIncludes('fanny');
        $this->assertSame(['fanny'], $transformer->getDefaultIncludes());

        $transformer->addDefaultIncludes(['summer', 'noFound']);

        $this->assertTrue(in_array('fanny', $transformer->getDefaultIncludes()));
        $this->assertTrue(in_array('summer', $transformer->getDefaultIncludes()));
        $this->assertFalse(in_array('noFound', $transformer->getDefaultIncludes()));
    }
}

