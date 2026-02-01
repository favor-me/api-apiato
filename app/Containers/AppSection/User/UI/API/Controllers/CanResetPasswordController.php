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

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\CanResetPasswordAction;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\UI\API\Requests\CanResetPasswordRequest;
use Illuminate\Http\JsonResponse;

class CanResetPasswordController extends UserApiRequest
{
    public function __invoke(CanResetPasswordRequest $request, CanResetPasswordAction $action): JsonResponse
    {
        $canReset = $action->run(
            $request->validated('token'),
            $request->validated(User::PHONE_NUMBER)
        );

        $responseStatus = $canReset ? JsonResponse::HTTP_OK : JsonResponse::HTTP_EXPECTATION_FAILED;

        return new JsonResponse([], $responseStatus);
    }
}
