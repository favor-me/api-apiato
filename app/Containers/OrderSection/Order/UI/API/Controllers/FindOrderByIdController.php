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
use App\Containers\OrderSection\Order\Actions\FindOrderByIdAction;
use App\Containers\OrderSection\Order\UI\API\Requests\FindOrderByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class FindOrderByIdController extends ApiController
{
    /**
     * @param FindOrderByIdRequest $request
     * @param FindOrderByIdAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        FindOrderByIdRequest $request,
        FindOrderByIdAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->id),
            $request->getTransformer()
        )->ok();
    }
}
