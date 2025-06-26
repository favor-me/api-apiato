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

use App\Ship\Parents\Tests\TestCase;
use App\Ship\Validation\Rules\PhoneNumber;
use Closure;

final class PhoneNumberTest extends TestCase
{
    public function test(): void
    {
        $rule = new PhoneNumber();

        collect([
            '+7(927)',
            '11111111111111111',
            '88455252',
            'hello is string'
        ])
            ->each(
                fn ($phone) => $rule->validate(
                    'phone',
                    $phone,
                    $this->assertMessage()
                )
            );
    }

    public function assertMessage(): Closure
    {
        return fn($message) => $this->assertSame(
            __('validation.phone.real_number'),
            $message
        );
    }
}
