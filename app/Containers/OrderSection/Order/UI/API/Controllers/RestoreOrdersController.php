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

use App\Containers\OrderSection\Order\Actions\RestoreOrdersAction;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Requests\RestoreOrdersRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreOrdersController extends ApiController
{
    /**
     * @param RestoreOrdersRequest $request
     * @param RestoreOrdersAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RestoreOrdersRequest $request,
        RestoreOrdersAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());

        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
