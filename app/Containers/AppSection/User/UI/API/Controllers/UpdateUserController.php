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
use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateUserController extends ApiController
{
    /**
     * @param UpdateUserRequest $request
     * @param UpdateUserAction $action
     * @return JsonResponse
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws UnknownProperties
     */
    public function __invoke(UpdateUserRequest $request, UpdateUserAction $action): JsonResponse
    {
        $user = $action->run($request->getDto());
        return Response::create($user, $request->getTransformer())->ok();
    }
}
