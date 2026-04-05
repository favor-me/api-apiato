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

use Apiato\Core\Facades\Response;
use App\Containers\ShiftSection\Shift\Actions\FindUserNowShiftAction;
use App\Containers\ShiftSection\Shift\UI\API\Requests\FindUserNowShiftRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class FindUserNowShiftController extends ApiController
{
    /**
     * @param FindUserNowShiftRequest $request
     * @param FindUserNowShiftAction $action
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function __invoke(
        FindUserNowShiftRequest $request,
        FindUserNowShiftAction $action
    ): JsonResponse {
        return Response::create(
            $action->run(),
            $request->getTransformer()
        )->ok();
    }
}
