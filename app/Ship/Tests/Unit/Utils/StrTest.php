<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Ship\Tests\Unit\Utils;

use App\Ship\Tests\UnitTestCase;
use App\Ship\Utils\Str;

final class StrTest extends UnitTestCase
{
    public function testToPath(): void
    {
        $this->assertSame('1/2/3/4/5', Str::toPath('12345'));
        $this->assertSame('1/2/3/4/5', Str::toPath(12345));
    }

    public function testToPhoneNumber(): void
    {
        //  Russian phone numbers.
        $this->assertSame(79991110022, Str::toPhoneNumber('+79991110022'));
        $this->assertSame(79991110022, Str::toPhoneNumber('+7(999) 111 00 22'));
        $this->assertSame(79991110022, Str::toPhoneNumber('+7-999-111-00-22'));
        $this->assertSame(79991110022, Str::toPhoneNumber('+7-(999)-111-00-22'));
        $this->assertSame(79991110022, Str::toPhoneNumber('8-(999)-111-00-22'));
        $this->assertSame(79991110022, Str::toPhoneNumber('89991110022'));
        $this->assertSame(12343585335, Str::toPhoneNumber('+12343585335'));

        //  Belarus phone numbers.
        $this->assertSame(375447913687, Str::toPhoneNumber('+375447913687'));
        $this->assertSame(375447913687, Str::toPhoneNumber('375447913687'));
        $this->assertSame(375447913687, Str::toPhoneNumber('37544-791-36-87'));
        $this->assertSame(375447913687, Str::toPhoneNumber('+375(447)-91-36-87'));
    }
}
