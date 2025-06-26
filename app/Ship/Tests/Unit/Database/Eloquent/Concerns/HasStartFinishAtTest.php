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

namespace App\Ship\Tests\Unit\Database\Eloquent\Concerns;

use App\Ship\Tests\Fackes\Models\HasStartFinishAtTestModel;
use App\Ship\Tests\UnitTestCase;

class HasStartFinishAtTest extends UnitTestCase
{
    public function testStartAt()
    {
        $model = new HasStartFinishAtTestModel([
            'start_at' => '10:00:00'
        ]);

        $this->assertSame('10:00', $model->start_at);
    }

    public function testFinishAt()
    {
        $model = new HasStartFinishAtTestModel([
            'finish_at' => '10:00:00'
        ]);

        $this->assertSame('10:00', $model->finish_at);
    }
}
