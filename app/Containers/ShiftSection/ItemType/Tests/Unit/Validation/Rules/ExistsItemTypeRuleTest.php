<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\ShiftSection\ItemType\Tests\Unit\Validation\Rules;

use App\Containers\ShiftSection\ItemType\Facades\Container;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Containers\ShiftSection\ItemType\Tests\UnitTestCase;
use App\Containers\ShiftSection\ItemType\Validation\Rules\ExistsItemTypeRule;

final class ExistsItemTypeRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsItemTypeRule();

        $rule->validate('type', 'failed_type', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });

        $rule->validate('type', 'confirm', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsItemTypeRule();
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
