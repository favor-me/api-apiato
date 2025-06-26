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

namespace App\Ship\Tests\Unit\SimpleTypes;

use App\Ship\SimpleTypes\Config\Money as MoneyConfig;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Tests\UnitTestCase;

class MoneyTest extends UnitTestCase
{
    public function testRegisterInApp(): void
    {
        $this->assertInstanceOf(Money::class, app('money'));
    }

    public function testDefaultRule(): void
    {
        $this->assertSame(MoneyConfig::EXCHANGE, app('money')->getRule());
    }

    public function testCurrency(): void
    {
        $money = app('money')->add(100);
        $this->assertSame(100.0, $money->val());
        $this->assertSame(1.0, $money->currency()->val());

        $money = app('money')->add('100 ' . MoneyConfig::CURRENCY);
        $this->assertSame(10000.0, $money->val());
        $this->assertSame(100.0, $money->currency()->val());
        $this->assertSame(100.0, $money->currency()->currency()->val());
    }
}
