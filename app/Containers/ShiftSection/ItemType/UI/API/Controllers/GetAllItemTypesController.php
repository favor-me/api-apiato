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

namespace App\Containers\ShiftSection\ItemType\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\ShiftSection\ItemType\Actions\GetAllItemTypesAction;
use App\Containers\ShiftSection\ItemType\UI\API\Requests\GetAllItemTypesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class GetAllItemTypesController extends ApiController
{
    public function __invoke(
        GetAllItemTypesRequest $request,
        GetAllItemTypesAction $action
    ): JsonResponse {
        return Response::create(
            $action->run(),
            $request->getTransformer()
        )->ok();
    }
}
