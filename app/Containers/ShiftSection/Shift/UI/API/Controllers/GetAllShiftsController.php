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

namespace App\Containers\ShiftSection\Shift\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Facades\Response;
use App\Containers\ShiftSection\Shift\Actions\GetAllShiftsAction;
use App\Containers\ShiftSection\Shift\UI\API\Requests\GetAllShiftsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllShiftsController extends ApiController
{
    /**
     * @param GetAllShiftsRequest $request
     * @param GetAllShiftsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllShiftsRequest $request,
        GetAllShiftsAction $action
    ): JsonResponse {
        if ($request->ifForWorker()) {
            $action->forAuthUser();
        }

        $models = $action->run($request->getLimit());

        return Response::create(
            $models,
            $request->getTransformer()
        )->ok();
    }
}
