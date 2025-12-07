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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationUnit\Actions\GetAllOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\GetAllOrganizationUnitsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsController extends ApiController
{
    /**
     * @param GetAllOrganizationUnitsRequest $request
     * @param GetAllOrganizationUnitsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOrganizationUnitsRequest $request,
        GetAllOrganizationUnitsAction $action
    ): JsonResponse {
        $models = $action
            ->setPriceFrom(
                $request->getPriceFrom()
            )
            ->organization($request->organization_id)
            ->run($request->isOnlyTrashed());

        return Response::create(
            $models,
            $request->getTransformer()
        )->ok();
    }
}
