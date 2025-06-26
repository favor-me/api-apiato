<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\UI\API\Requests\RegisterUserRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegisterUserController extends ApiController
{
    /**
     * @param RegisterUserRequest $request
     * @param RegisterUserAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     */
    public function __invoke(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run($request->getDto()),
                $request->getTransformer()
            )
        );
    }
}
