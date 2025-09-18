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

namespace App\Containers\OrderSection\PaymentType\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\OrderSection\PaymentType\Actions\GetAllPaymentTypesAction;
use App\Containers\OrderSection\PaymentType\UI\API\Requests\GetAllPaymentTypesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class GetAllPaymentTypesController extends ApiController
{
    /**
     * @param GetAllPaymentTypesRequest $request
     * @param GetAllPaymentTypesAction $action
     * @return JsonResponse
     */
    public function __invoke(GetAllPaymentTypesRequest $request, GetAllPaymentTypesAction $action): JsonResponse
    {
        return Response::create(
            $action->run(),
            $request->getTransformer()
        )->ok();
    }
}
