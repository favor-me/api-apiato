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

use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\DB;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\Tasks\CheckIfUserEmailIsConfirmedTask;
use App\Containers\AppSection\Authentication\Tasks\ExtractLoginCustomAttributeTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyLoginPasswordGrantRequest;

/**
 * Class ProxyLoginForWebClientAction
 *
 * @package App\Containers\AppSection\Authentication\Actions
 */
class ProxyLoginForWebClientAction extends Action
{
    /**
     * Run action.
     *
     * @param   ProxyLoginPasswordGrantRequest $request
     *
     * @return  array
     *
     * @throws  LoginFailedException
     * @throws  UserNotConfirmedException
     */
    public function run(ProxyLoginPasswordGrantRequest $request): array
    {
        $sanitizedData = $request->sanitizeInput(
            array_merge(
                array_keys(config('appSection-authentication.login.attributes')),
                ['password']
            )
        );

        $loginCustomAttribute = app(ExtractLoginCustomAttributeTask::class)->run($sanitizedData);

        $sanitizedData['username'] = $loginCustomAttribute['username'];
        $sanitizedData['client_id'] = config('appSection-authentication.clients.web.id');
        $sanitizedData['client_secret'] = config('appSection-authentication.clients.web.secret');
        $sanitizedData['grant_type'] = 'password';
        $sanitizedData['scope'] = '';

        $responseContent = app(CallOAuthServerTask::class)->run(
            $sanitizedData,
            $request->headers->get('accept-language')
        );

        $this->processEmailConfirmationIfNeeded($responseContent);
        $refreshCookie = app(MakeRefreshCookieTask::class)->run($responseContent['refresh_token']);

        return [
            'response_content' => $responseContent,
            'refresh_cookie' => $refreshCookie,
        ];
    }

    /**
     * Extract user from auth server response.
     *
     * @param   $response
     *
     * @return  mixed
     */
    private function extractUserFromAuthServerResponse($response)
    {
        $tokenId = app(Parser::class)->parse($response['access_token'])->claims()->get('jti');
        $userAccessRecord = DB::table('oauth_access_tokens')->find($tokenId);
        return User::find($userAccessRecord->user_id);
    }

    /**
     * Process email confirmation if needed.
     *
     * @param   $response
     *
     * @throws  UserNotConfirmedException
     */
    private function processEmailConfirmationIfNeeded($response): void
    {
        $user = $this->extractUserFromAuthServerResponse($response);
        $isUserConfirmed = app(CheckIfUserEmailIsConfirmedTask::class)->run($user);

        if (!$isUserConfirmed) {
            throw new UserNotConfirmedException();
        }
    }
}
