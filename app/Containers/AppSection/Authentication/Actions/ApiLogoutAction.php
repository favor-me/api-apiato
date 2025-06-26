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
use App\Ship\Parents\Actions\Action;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;

/**
 * Class ApiLogoutAction
 *
 * @package App\Containers\AppSection\Authentication\Actions
 */
class ApiLogoutAction extends Action
{
    /**
     * Run action.
     *
     * @param LogoutRequest $request
     */
    public function run(LogoutRequest $request): void
    {
        $id = app(Parser::class)->parse($request->bearerToken())->claims()->get('jti');
        app(TokenRepository::class)->revokeAccessToken($id);
        app(RefreshTokenRepository::class)->revokeRefreshTokensByAccessTokenId($id);
    }
}
