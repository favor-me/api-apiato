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
use App\Containers\AppSection\User\Actions\FindOwnUserByIdAction;
use App\Containers\AppSection\User\Exceptions\UserIsNotOrganizationOwnerException;
use App\Containers\AppSection\User\UI\API\Requests\FindOwnUserByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class FindOwnUserByIdController extends ApiController
{
    /**
     * @param FindOwnUserByIdRequest $request
     * @param FindOwnUserByIdAction $action
     * @return JsonResponse
     * @throws NotFoundException
     * @throws RepositoryException
     * @throws UserIsNotOrganizationOwnerException
     */
    public function __invoke(FindOwnUserByIdRequest $request, FindOwnUserByIdAction $action): JsonResponse
    {
        return Response::create(
            $action->run($request->getId()),
            $request->getTransformer()
        )->ok();
    }
}
