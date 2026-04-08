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

use App\Containers\ShiftSection\Shift\Actions\ConfirmShiftsAction;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Requests\ConfirmShiftsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class ConfirmShiftsController extends ApiController
{
    public function __invoke(
        ConfirmShiftsRequest $request,
        ConfirmShiftsAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleConfirmed($result)
        ]);
    }
}
