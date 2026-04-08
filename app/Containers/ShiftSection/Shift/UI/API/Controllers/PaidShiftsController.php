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

use App\Containers\ShiftSection\Shift\Actions\PaidShiftsAction;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\UI\API\Requests\PaidShiftsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class PaidShiftsController extends ApiController
{
    public function __invoke(
        PaidShiftsRequest $request,
        PaidShiftsAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultiplePaid($result)
        ]);
    }
}
