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

use App\Containers\AppSection\User\Actions\ResetPasswordAction;
use App\Containers\AppSection\User\UI\API\Requests\ResetPasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResetPasswordController extends ApiController
{
    /**
     * @param ResetPasswordRequest $request
     * @param ResetPasswordAction $action
     * @return JsonResponse
     * @throws InternalErrorException
     * @throws UnknownProperties
     */
    public function __invoke(ResetPasswordRequest $request, ResetPasswordAction $action): JsonResponse
    {
        $resetPasswordStatus = $action->run($request->getDto());

        $responseStatus = $resetPasswordStatus === Password::PASSWORD_RESET ?
            JsonResponse::HTTP_OK : JsonResponse::HTTP_EXPECTATION_FAILED;

        return $this->json([
            MESSAGE => __($resetPasswordStatus)
        ], $responseStatus);
    }
}
