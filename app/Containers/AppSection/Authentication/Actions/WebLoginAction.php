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

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\Authentication\Tasks\LoginTask;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\Tasks\CheckIfUserEmailIsConfirmedTask;
use App\Containers\AppSection\Authentication\Tasks\ExtractLoginCustomAttributeTask;

class WebLoginAction extends Action
{
    /**
     * @param LoginRequest $request
     * @return User|null
     * @throws LoginFailedException
     * @throws UserNotConfirmedException
     */
    public function run(LoginRequest $request): ?User
    {
        $sanitizedData = $request->sanitizeInput([
            'email',
            'password',
            'remember_me' => true
        ]);

        $loginCustomAttribute = app(ExtractLoginCustomAttributeTask::class)->run($sanitizedData);

        $isSuccessful = app(LoginTask::class)->run(
            $loginCustomAttribute['username'],
            $sanitizedData['password'],
            $loginCustomAttribute['loginAttribute'],
            $sanitizedData['remember_me']
        );

        $user = null;
        if ($isSuccessful) {
            $user = Auth::user();
        } else {
            throw new LoginFailedException();
        }

        $isUserConfirmed = app(CheckIfUserEmailIsConfirmedTask::class)->run($user);

        if (!$isUserConfirmed) {
            throw new UserNotConfirmedException();
        }

        $this->saveApiToken($user, $sanitizedData['password']);

        return $user;
    }

    /**
     * @param User $user
     * @param string $password
     * @return void
     * @throws LoginFailedException
     */
    protected function saveApiToken(User $user, string $password): void
    {
        $responseContent = app(CallOAuthServerTask::class)->run(
            [
                'password' => $password,
                'username' => $user->email,
                'client_id' => config('appSection-authentication.clients.web.id'),
                'client_secret' => config('appSection-authentication.clients.web.secret'),
                'grant_type' => 'password',
                'scope' => ''
            ],
            request()->headers->get('accept-language')
        );

        session([
            API_TOKEN_KEY => $responseContent['access_token'],
            API_REFRESH_TOKEN_KEY => $responseContent['refresh_token']
        ]);
    }
}
