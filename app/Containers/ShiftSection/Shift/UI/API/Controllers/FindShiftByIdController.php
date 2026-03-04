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
use App\Containers\ShiftSection\Shift\Actions\FindShiftByIdAction;
use App\Containers\ShiftSection\Shift\UI\API\Requests\FindShiftByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class FindShiftByIdController extends ApiController
{
    /**
     * @param FindShiftByIdRequest $request
     * @param FindShiftByIdAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        FindShiftByIdRequest $request,
        FindShiftByIdAction $action
    ): JsonResponse {
        return Response::create(
            $action->run($request->id),
            $request->getTransformer()
        )->ok();
    }
}
