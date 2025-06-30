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

namespace App\Containers\CommunitySection\Organization\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\Organization\Actions\UpdateOrganizationAction;
use App\Containers\CommunitySection\Organization\UI\API\Requests\UpdateOwnOrganizationRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOwnOrganizationController extends ApiController
{
    /**
     * @param UpdateOwnOrganizationRequest $request
     * @param UpdateOrganizationAction $action
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(UpdateOwnOrganizationRequest $request, UpdateOrganizationAction $action): JsonResponse
    {
        $organization = $action->run($request->getDto());

        return Response::create(
            $organization,
            $request->getTransformer()
        )
            ->ok();
    }
}
