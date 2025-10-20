<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationUnit\Actions\PlusOrganizationUnitBalanceAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\PlusOrganizationUnitBalanceRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class PlusOrganizationUnitBalanceController extends ApiController
{
    /**
     * @param PlusOrganizationUnitBalanceRequest $request
     * @param PlusOrganizationUnitBalanceAction $action
     * @return JsonResponse
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function __invoke(
        PlusOrganizationUnitBalanceRequest $request,
        PlusOrganizationUnitBalanceAction $action
    ): JsonResponse {
        $unit = app(PlusOrganizationUnitBalanceAction::class)
            ->run(
                $request->getId(),
                $request->getBalance(),
                $request->isInfinityBalance()
            );

        return Response::create($unit, $request->getTransformer())->ok();
    }
}
