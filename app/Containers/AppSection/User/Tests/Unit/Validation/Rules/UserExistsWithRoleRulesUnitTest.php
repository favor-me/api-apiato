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

namespace App\Containers\AppSection\User\Tests\Unit\Validation\Rules;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\Validation\Rules\UserExistsWithRoleRules;

final class UserExistsWithRoleRulesUnitTest extends UnitTestCase
{
    public function testInvalidUserAndValidRole(): void
    {
        $rule = new UserExistsWithRoleRules(Role::SPECIALIST);

        $rule->validate('user_id', 444, function (string $message) {
            $this->assertSame(__('appSection@user::validation.exists_with_role'), $message);
        });
    }

    public function testInvalidUserAndRole(): void
    {
        $rule = new UserExistsWithRoleRules('no-exists');

        $rule->validate('user_id', 444, function (string $message) {
            $this->assertSame(__('appSection@user::validation.exists_with_role'), $message);
        });
    }
}
