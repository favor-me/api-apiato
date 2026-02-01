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

namespace App\Containers\AppSection\Authentication\Password;

use App\Containers\AppSection\User\Foundation\User;
use Closure;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Arr;
use UnexpectedValueException;

class PasswordBroker implements PasswordBrokerContract
{
    public function __construct(
        protected TokenRepositoryInterface $tokens,
        protected UserProvider $users
    ) {
    }

    public function sendResetLink(array $credentials, ?Closure $callback = null): string
    {
        return static::INVALID_USER;
    }

    public function reset(array $credentials, Closure $callback): string
    {
        $user = $this->validateReset($credentials);

        if (!$user instanceof CanResetPassword) {
            return $user;
        }

        $password = $credentials[User::PASSWORD];

        $callback($user, $password);

        $this->tokens->delete($user);

        return static::PASSWORD_RESET;
    }

    public function createToken(CanResetPassword $user): string
    {
        return $this->tokens->create($user);
    }

    public function getUser(array $credentials): ?CanResetPassword
    {
        $credentials = Arr::except($credentials, ['token']);

        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && ! $user instanceof CanResetPassword) {
            throw new UnexpectedValueException('User must implement CanResetPassword interface.');
        }

        return $user;
    }

    protected function validateReset(array $credentials): string|CanResetPassword
    {
        if (is_null($user = $this->getUser($credentials))) {
            return static::INVALID_USER;
        }

        if (!$this->tokens->exists($user, $credentials['token'])) {
            return static::INVALID_TOKEN;
        }

        return $user;
    }
}
