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

namespace App\Containers\AccountingSection\Contract\UI\API\Controllers;

use App\Containers\AccountingSection\Contract\Actions\RestoreContractsAction;
use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\UI\API\Requests\RestoreContractsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreContractsController extends ApiController
{
    /**
     * @param RestoreContractsRequest $request
     * @param RestoreContractsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RestoreContractsRequest $request,
        RestoreContractsAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());

        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
