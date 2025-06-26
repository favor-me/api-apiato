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

namespace App\Containers\AppSection\User\Tests;

use App\Containers\AppSection\User\Models\User;

class UnitTestCase extends ContainerTestCase
{
    protected array $testData = [
        'email' => 'new@test.email',
        'password' => '123456789',
        'name' => 'Name',
        'patronymic' => 'Patronymic',
        'surname' => 'Surname'
    ];

    protected function getSuperUser(): User
    {
        return User::where('email', config('appSection-user.super-admin-email'))->get()->first();
    }
}
