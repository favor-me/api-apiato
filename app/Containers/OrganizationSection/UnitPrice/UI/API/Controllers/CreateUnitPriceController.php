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

use Apiato\Core\Facades\Response;
use App\Containers\OrganizationSection\UnitPrice\Actions\CreateUnitPriceAction;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Requests\CreateUnitPriceRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateUnitPriceController extends ApiController
{
    /**
     * @param CreateUnitPriceRequest $request
     * @param CreateUnitPriceAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function __invoke(
        CreateUnitPriceRequest $request,
        CreateUnitPriceAction $action
    ): JsonResponse {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->created();
    }
}
