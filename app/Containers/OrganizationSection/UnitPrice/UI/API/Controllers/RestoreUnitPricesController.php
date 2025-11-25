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

use App\Containers\OrganizationSection\UnitPrice\Actions\RestoreUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Requests\RestoreUnitPricesRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreUnitPricesController extends ApiController
{
    /**
     * @param RestoreUnitPricesRequest $request
     * @param RestoreUnitPricesAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RestoreUnitPricesRequest $request,
        RestoreUnitPricesAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());

        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
