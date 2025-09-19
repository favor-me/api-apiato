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
use App\Containers\OrderSection\Order\Actions\UpdateOrderAction;
use App\Containers\OrderSection\Order\UI\API\Requests\UpdateOrderRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrderController extends ApiController
{
    /**
     * @param UpdateOrderRequest $request
     * @param UpdateOrderAction $action
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(
        UpdateOrderRequest $request,
        UpdateOrderAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->ok();
    }
}
