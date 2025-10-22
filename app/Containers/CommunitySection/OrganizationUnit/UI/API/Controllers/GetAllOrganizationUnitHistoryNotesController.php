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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationUnit\Actions\GetAllOrganizationUnitHistoryNotesAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\GetAllOrganizationUnitHistoryNotesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitHistoryNotesController extends ApiController
{
    /**
     * @param GetAllOrganizationUnitHistoryNotesRequest $request
     * @param GetAllOrganizationUnitHistoryNotesAction $action
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOrganizationUnitHistoryNotesRequest $request,
        GetAllOrganizationUnitHistoryNotesAction $action
    ): JsonResponse {
        return Response::create(
            $action->run($request->getLimit()),
            $request->getTransformer()
        )->ok();
    }
}
