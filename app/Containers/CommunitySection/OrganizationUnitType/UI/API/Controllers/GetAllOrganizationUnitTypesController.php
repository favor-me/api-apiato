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

namespace App\Containers\CommunitySection\OrganizationUnitType\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationUnitType\Actions\GetAllOrganizationUnitTypesAction;
use App\Containers\CommunitySection\OrganizationUnitType\UI\API\Requests\GetAllOrganizationUnitTypesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class GetAllOrganizationUnitTypesController extends ApiController
{
    /**
     * @param GetAllOrganizationUnitTypesRequest $request
     * @param GetAllOrganizationUnitTypesAction $action
     * @return JsonResponse
     */
    public function __invoke(
        GetAllOrganizationUnitTypesRequest $request,
        GetAllOrganizationUnitTypesAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run(),
            $request->getTransformer()
        )->ok();
    }
}
