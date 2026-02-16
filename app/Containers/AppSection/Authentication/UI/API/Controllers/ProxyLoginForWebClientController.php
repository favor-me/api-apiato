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

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ProxyLoginForWebClientAction;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyLoginPasswordGrantRequest;
use App\Ship\Middlewares\Http\AcceptTimeZone;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class ProxyLoginForWebClientController extends ApiController
{
    /**
     * @param ProxyLoginPasswordGrantRequest $request
     * @return JsonResponse
     * @throws LoginFailedException
     * @throws UserNotConfirmedException
     */
    public function __invoke(ProxyLoginPasswordGrantRequest $request): JsonResponse
    {
        $result = app(ProxyLoginForWebClientAction::class)->run($request);

        /** @var SymfonyCookie $refreshCookie */
        $refreshCookie = $result['refresh_cookie'];

        $timezoneCookie = Cookie::make(
            'timezone',
            $request->header(AcceptTimeZone::HEADER),
            $refreshCookie->getExpiresTime()
        );

        return $this
            ->json($result['response_content'])
            ->withCookie($refreshCookie)
            ->withCookie($timezoneCookie);
    }
}
