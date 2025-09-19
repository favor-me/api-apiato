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

namespace App\Containers\OrderSection\Item\UI\API\Controllers;

use App\Containers\OrderSection\Item\Actions\DeleteItemsAction;
use App\Containers\OrderSection\Item\Facades\Container;
use App\Containers\OrderSection\Item\UI\API\Requests\DeleteItemsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteItemsController extends ApiController
{
    /**
     * @param DeleteItemsRequest $request
     * @param DeleteItemsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        DeleteItemsRequest $request,
        DeleteItemsAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
