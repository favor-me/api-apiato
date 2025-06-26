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

namespace App\Ship\Tests\Unit\Validation\Rules;

use App\Ship\Tests\UnitTestCase;
use App\Ship\Validation\Rules\Time;

class TimeTest extends UnitTestCase
{
    public function testRulePasses()
    {
        $rule = new Time();

        $this->assertTrue($rule->passes(null, '10:00'));
        $this->assertTrue($rule->passes(null, '20:00'));
        $this->assertTrue($rule->passes(null, '00:00'));

        $this->assertFalse($rule->passes(null, '1:10'));
        $this->assertFalse($rule->passes(null, '10:00:00'));
        $this->assertFalse($rule->passes(null, '40:00'));
        $this->assertFalse($rule->passes(null, '10:00:101'));
        $this->assertFalse($rule->passes(null, 1111));
    }

    public function testRuleMessage()
    {
        $rule = new Time();
        $this->assertSame(__('ship::rules.time.message'), $rule->message());
    }
}
