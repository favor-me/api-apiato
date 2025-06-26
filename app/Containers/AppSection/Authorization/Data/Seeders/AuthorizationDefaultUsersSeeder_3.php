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

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Dto\RegisterUserDto;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Seeders\Seeder;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

// @codingStandardsIgnoreStart

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    /**
     * @return void
     * @throws UnknownProperties
     */
    public function run(): void
    {
        $this->createSuperUser();
    }

    /**
     * @return void
     * @throws UnknownProperties
     */
    private function createSuperUser(): void
    {
        $dto = new RegisterUserDto([
            'password' => '375210',
            'name' => 'Сергей',
            'patronymic' => 'Михайлович',
            'surname' => 'Калистратов',
            'login' => 'admin',
            'phone_number' => 79272236974,
            'email' => config('appSection-user.super-admin-email'),
            'is_admin' => true
        ]);

        $admin = app(CreateUserByCredentialsTask::class)->run($dto);

        $admin->assignRole([
            Role::ADMIN
        ]);

        $admin->setAttribute('email_verified_at', now());
        $admin->save();
    }
}
