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

namespace App\Containers\OrderSection\PaymentType\Tests\Unit\Validation\Rules;

use App\Containers\OrderSection\PaymentType\Facades\Container;
use App\Containers\OrderSection\PaymentType\Manager;
use App\Containers\OrderSection\PaymentType\Tests\UnitTestCase;
use App\Containers\OrderSection\PaymentType\Validation\Rules\ExistsPaymentTypeRule;

final class ExistsPaymentTypeRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsPaymentTypeRule();

        $rule->validate('type', 'no_exists_type', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });

        $rule->validate('type', 'confirm', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsPaymentTypeRule();
        $this->assertSame($this->getExpectedMessage(), $rule->message());
    }

    protected function getExpectedMessage(): string
    {
        $types = Manager::getInstance()
            ->all()
            ->implode(', ');

        return Container::trans('container.validation.exists', [
            'types' => $types
        ]);
    }
}
