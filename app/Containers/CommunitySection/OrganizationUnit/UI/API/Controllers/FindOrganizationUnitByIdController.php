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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationUnit\Actions\FindOrganizationUnitByIdAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\FindOrganizationUnitByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class FindOrganizationUnitByIdController extends ApiController
{
    /**
     * @param FindOrganizationUnitByIdRequest $request
     * @param FindOrganizationUnitByIdAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        FindOrganizationUnitByIdRequest $request,
        FindOrganizationUnitByIdAction $action
    ): JsonResponse {
        $unit = $action
            ->priceList(
                $request->getPriceModel(),
                $request->getPriceModelId()
            )
            ->run($request->id);

        return Response::create(
            $unit,
            $request->getTransformer()
        )->ok();
    }
}
