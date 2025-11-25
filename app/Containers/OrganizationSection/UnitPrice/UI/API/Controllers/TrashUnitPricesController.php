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

namespace App\Containers\OrganizationSection\UnitPrice\UI\API\Controllers;

use App\Containers\OrganizationSection\UnitPrice\Actions\TrashUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Requests\TrashUnitPricesRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class TrashUnitPricesController extends ApiController
{
    /**
     * @param TrashUnitPricesRequest $request
     * @param TrashUnitPricesAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(
        TrashUnitPricesRequest $request,
        TrashUnitPricesAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
