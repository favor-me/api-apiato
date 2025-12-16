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

namespace App\Containers\OrganizationSection\OwnershipType\Tests\Unit\Validation\Rules;

use App\Containers\OrganizationSection\OwnershipType\Facades\Container;
use App\Containers\OrganizationSection\OwnershipType\Manager;
use App\Containers\OrganizationSection\OwnershipType\Tests\UnitTestCase;
use App\Containers\OrganizationSection\OwnershipType\Validation\Rules\ExistsOwnershipTypeRule;

final class ExistsOwnershipTypeRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsOwnershipTypeRule();

        $rule->validate('type', 'failed_type', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });

        $rule->validate('type', 'confirm', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsOwnershipTypeRule();
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
