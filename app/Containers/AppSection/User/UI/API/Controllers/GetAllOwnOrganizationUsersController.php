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
use App\Containers\AppSection\User\Actions\GetAllOrganizationUsersAction;
use App\Containers\AppSection\User\UI\API\Requests\GetAllOwnOrganizationUsersRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Apiato\Core\Exceptions\CoreInternalErrorException;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOwnOrganizationUsersController extends ApiController
{
    /**
     * @param GetAllOwnOrganizationUsersRequest $request
     * @param GetAllOrganizationUsersAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOwnOrganizationUsersRequest $request,
        GetAllOrganizationUsersAction     $action
    ): JsonResponse
    {
        $users = $action->run($request->getOrganizationId(), $request->getAuthUserId());
        return Response::create($users, $request->getTransformer())->ok();
    }
}
