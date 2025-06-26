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

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\User\UI\API\Requests\ExistsUserLoginRequest;
use Illuminate\Http\JsonResponse;

class PublicController extends ApiController
{
    /**
     * @param ExistsUserLoginRequest $request
     * @return JsonResponse
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function existsUserLogin(ExistsUserLoginRequest $request): JsonResponse
    {
        return $this->json([
            MESSAGE => __('appSection@user::user.login_can_be_used')
        ]);
    }
}
