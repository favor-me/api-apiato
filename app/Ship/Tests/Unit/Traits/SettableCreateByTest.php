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

namespace App\Ship\Tests\Unit\Traits;

use App\Ship\Tests\UnitTestCase;
use App\Ship\Traits\SettableCreatedBy;

class SettableCreateByTest extends UnitTestCase
{
    use SettableCreatedBy;

    public function testCreateBy()
    {
        $this->assertNull($this->getCreatedBy());
    }

    public function testSetCreateBy()
    {
        $userId = 4;
        $this->assertInstanceOf(self::class, $this->setCreatedBy($userId));
        $this->assertSame($userId, $this->getCreatedBy());
    }
}
