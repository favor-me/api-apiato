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

namespace App\Containers\AppSection\User\Tests\Unit\Validation\Rules;

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\Validation\Rules\UserHasNowShiftRule;
use App\Containers\OrganizationSection\Shift\Models\Shift;

final class UserHasNowShiftRuleTest extends UnitTestCase
{
    public function testWithoutUser(): void
    {
        $rule = new UserHasNowShiftRule($this->testingUser);

        $rule->validate('shift_id', 123, function (string $message) {
            $this->assertSame(Container::trans('user.not_found'), $message);
        });
    }

    public function testWithAuthUserNoExistNowShift(): void
    {
        $this->getTestingOrganizationUser();

        $rule = new UserHasNowShiftRule($this->testingUser);

        $rule->validate('shift_id', 123, function (string $message) {
            $this->assertSame(Container::trans('user.not_found_now_shift'), $message);
        });
    }

    public function testWithAuthUserAndNotCurrentShiftId(): void
    {
        $this->getTestingOrganizationUser();

        Shift::factory()->create();

        $rule = new UserHasNowShiftRule($this->testingUser);

        $rule->validate('shift_id', 1234, function (string $message) {
            $this->assertSame(Container::trans('validation.has_now_shift.invalid_shift'), $message);
        });
    }
}
