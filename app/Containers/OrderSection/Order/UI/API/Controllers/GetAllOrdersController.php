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

namespace App\Containers\OrderSection\Order\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use Apiato\Core\Facades\Response;
use App\Containers\OrderSection\Order\Actions\GetAllOrdersAction;
use App\Containers\OrderSection\Order\UI\API\Requests\GetAllOrdersRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrdersController extends ApiController
{
    /**
     * @param GetAllOrdersRequest $request
     * @param GetAllOrdersAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOrdersRequest $request,
        GetAllOrdersAction  $action
    ): JsonResponse
    {
        $models = $action
            ->organization($request->organization_id)
            ->run($request->isOnlyTrashed());
        return Response::create(
            $models,
            $request->getTransformer()
        )->ok();
    }
}
