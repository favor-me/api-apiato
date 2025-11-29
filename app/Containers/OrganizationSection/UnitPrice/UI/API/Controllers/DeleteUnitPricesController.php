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

use App\Containers\OrganizationSection\UnitPrice\Actions\DeleteUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Requests\DeleteUnitPricesRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteUnitPricesController extends ApiController
{
    /**
     * @param DeleteUnitPricesRequest $request
     * @param DeleteUnitPricesAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        DeleteUnitPricesRequest $request,
        DeleteUnitPricesAction $action
    ): JsonResponse {
        $result = $action->run(
            $request->getModelType(),
            $request->model_id,
            $request->unit_ids
        );

        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
