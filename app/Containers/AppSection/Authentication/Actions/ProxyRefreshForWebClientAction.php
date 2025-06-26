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

use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Request;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyRefreshRequest;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;

/**
 * Class ProxyRefreshForWebClientAction
 *
 * @package App\Containers\AppSection\Authentication\Actions
 */
class ProxyRefreshForWebClientAction extends Action
{
    /**
     * Run action.
     *
     * @param   ProxyRefreshRequest $request
     *
     * @return  array
     *
     * @throws  RefreshTokenMissedException
     * @throws  LoginFailedException
     */
    public function run(ProxyRefreshRequest $request): array
    {
        $sanitizedData = $request->sanitizeInput([
            'refresh_token',
        ]);

        $sanitizedData['refresh_token'] = $sanitizedData['refresh_token'] ?: Request::cookie('refreshToken');
        $sanitizedData['client_id'] = config('appSection-authentication.clients.web.id');
        $sanitizedData['client_secret'] = config('appSection-authentication.clients.web.secret');
        $sanitizedData['grant_type'] = 'refresh_token';
        $sanitizedData['scope'] = '';

        if (!$sanitizedData['refresh_token']) {
            throw new RefreshTokenMissedException();
        }

        $responseContent = app(CallOAuthServerTask::class)->run(
            $sanitizedData,
            $request->headers->get('accept-language')
        );

        $refreshCookie = app(MakeRefreshCookieTask::class)->run($responseContent['refresh_token']);

        return [
            'response_content' => $responseContent,
            'refresh_cookie' => $refreshCookie
        ];
    }
}
