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

use App\Containers\AccountingSection\Contract\Actions\TrashContractsAction;
use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\UI\API\Requests\TrashContractsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class TrashContractsController extends ApiController
{
    /**
     * @param TrashContractsRequest $request
     * @param TrashContractsAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(
        TrashContractsRequest $request,
        TrashContractsAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
