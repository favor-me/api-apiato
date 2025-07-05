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

namespace App\Containers\CommunitySection\OrganizationUnitType\Tests\Unit\Validation\Rules;

use App\Containers\CommunitySection\OrganizationUnitType\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\Tests\UnitTestCase;
use App\Containers\CommunitySection\OrganizationUnitType\Validation\Rules\ExistsOrganizationUnitTypeRule;

final class ExistsOrganizationUnitTypeRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsOrganizationUnitTypeRule();

        $rule->validate('type', 'no_exists_type', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });

        $rule->validate('type', 'confirm', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsOrganizationUnitTypeRule();
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
