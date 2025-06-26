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

namespace App\Ship\Middlewares\Http;

use App\Containers\AppSection\User\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Ship\Exceptions\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Auth\AuthenticationException as BaseAuthenticationException;

/**
 * Class Authenticate
 *
 * @package App\Ship\Middlewares\Http
 */
class Authenticate extends LaravelAuthenticate
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param   Request $request
     * @param   array $guards
     *
     * @throws  AuthenticationException
     * @throws  BaseAuthenticationException
     */
    public function authenticate($request, array $guards): void
    {
        try {
            $authorizationHeader = $request->headers->get('Authorization');
            if (str_starts_with($authorizationHeader, 'Basic')) {
                $this->basicAuthenticate($authorizationHeader);
            } else {
                parent::authenticate($request, $guards);
            }
        } catch (Exception $exception) {
            if ($request->expectsJson()) {
                throw new AuthenticationException();
            } else {
                $this->unauthenticated($request, $guards);
            }
        }
    }

    protected function basicAuthenticate($authorizationHeader): void
    {
        $basicAuthorizationData = str_replace('Basic ', null, $authorizationHeader);
        $basicDecodeData = base64_decode($basicAuthorizationData);

        if (str_contains($basicDecodeData, ':')) {
            list($login, $password) = explode(':', $basicDecodeData);
            /** @var null|User $user */
            $user = User::where('email', $login)
                ->where('password', $password)
                ->first();

            if (is_null($user)) {
                throw new AuthenticationException();
            }

            $this->auth->guard()->login($user);
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param   Request $request
     *
     * @return  string|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function redirectTo($request): ?string
    {
        return route(Config::get('appSection-authentication.login-page-url'));
    }
}
