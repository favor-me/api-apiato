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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Unit\Validation\Rules;

use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use App\Containers\OrganizationSection\UnitPrice\Validation\Rules\ExistsUnitPriceModelRule;

final class ExistsUnitPriceModelRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsUnitPriceModelRule();

        $rule->validate('model', 'no_exists_type', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsUnitPriceModelRule();
        $this->assertSame($this->getExpectedMessage(), $rule->message());
    }

    protected function getExpectedMessage(): string
    {
        $types = Manager::getInstance()
            ->all()
            ->map(fn(Type $type) => $type->getModelKey())
            ->implode(', ');

        return Container::trans('container.validation.exists', [
            'types' => $types
        ]);
    }
}
