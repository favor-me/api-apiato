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

use App\Containers\OrderSection\Order\Actions\TrashOrdersAction;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\UI\API\Requests\TrashOrdersRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class TrashOrdersController extends ApiController
{
    /**
     * @param TrashOrdersRequest $request
     * @param TrashOrdersAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(
        TrashOrdersRequest $request,
        TrashOrdersAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
