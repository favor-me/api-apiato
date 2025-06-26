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

use App\Containers\AppSection\Authentication\Actions\ProxyRefreshForWebClientAction;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyRefreshRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class ProxyRefreshForWebClientController extends ApiController
{
    /**
     * @param ProxyRefreshRequest $request
     * @return JsonResponse
     * @throws LoginFailedException
     * @throws RefreshTokenMissedException
     */
    public function __invoke(ProxyRefreshRequest $request): JsonResponse
    {
        $result = app(ProxyRefreshForWebClientAction::class)->run($request);
        return $this
            ->json($result['response_content'])
            ->withCookie($result['refresh_cookie']);
    }
}
