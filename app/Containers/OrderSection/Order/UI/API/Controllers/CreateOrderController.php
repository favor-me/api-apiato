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

use Apiato\Core\Facades\Response;
use App\Containers\OrderSection\Order\Actions\CreateOrderAction;
use App\Containers\OrderSection\Order\UI\API\Requests\CreateOrderRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrderController extends ApiController
{
    /**
     * @param CreateOrderRequest $request
     * @param CreateOrderAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function __invoke(
        CreateOrderRequest $request,
        CreateOrderAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->created();
    }
}
