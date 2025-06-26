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

namespace App\Containers\AppSection\User\UI\CLI\Commands;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\UI\API\Requests\CreateAdminRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Commands\ConsoleCommand;

class CreateAdminCommand extends ConsoleCommand
{
    /**
     * @var string
     */
    protected $signature = 'apiato:create:admin';

    /**
     * @var string
     */
    protected $description = 'Create a new User with the ADMIN role';

    /**
     * @throws CreateResourceFailedException
     */
    public function handle(): void
    {
        $username = $this->ask('Enter the username for this user');
        $email = $this->ask('Enter the email address of this user');
        $password = $this->secret('Enter the password for this user');
        $password_confirmation = $this->secret('Please confirm the password');

        if ($password !== $password_confirmation) {
            $this->error('Passwords do not match - exiting!');
            return;
        }

        $request = new CreateAdminRequest([
            'name' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        app(CreateAdminAction::class)->run($request);

        $this->info('Admin ' . $email . ' was successfully created');
    }
}
