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

namespace App\Containers\ShiftSection\Item\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\ShiftSection\Item\Actions\UpdateItemAction;
use App\Containers\ShiftSection\Item\UI\API\Requests\UpdateItemRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateItemController extends ApiController
{
    /**
     * @param UpdateItemRequest $request
     * @param UpdateItemAction $action
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(
        UpdateItemRequest $request,
        UpdateItemAction $action
    ): JsonResponse {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->ok();
    }
}
