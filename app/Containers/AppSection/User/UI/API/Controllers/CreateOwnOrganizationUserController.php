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

use Apiato\Core\Facades\Response;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\UI\API\Requests\CreateOwnOrganizationUserRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOwnOrganizationUserController extends ApiController
{
    /**
     * @param CreateOwnOrganizationUserRequest $request
     * @param RegisterUserAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function __invoke(CreateOwnOrganizationUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        $user = $action->run($request->getDto());
        return Response::create($user, $request->getTransformer())->created();
    }
}
