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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Facades\Response;
use App\Containers\OrganizationSection\UnitPrice\Actions\GetAllUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Requests\GetAllUnitPricesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllUnitPricesController extends ApiController
{
    /**
     * @param GetAllUnitPricesRequest $request
     * @param GetAllUnitPricesAction $action
     * @return JsonResponse
     */
    public function __invoke(
        GetAllUnitPricesRequest $request,
        GetAllUnitPricesAction $action
    ): JsonResponse {
        $models = $action
            ->run(
                $request->getModelType(),
                $request->model_id,
                $request->getLimit()
            );

        return Response::create(
            $models,
            $request->getTransformer()
        )->ok();
    }
}
