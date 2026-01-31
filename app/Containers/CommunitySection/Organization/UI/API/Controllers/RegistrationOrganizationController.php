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
use App\Containers\CommunitySection\Organization\Actions\RegistrationOrganizationAction;
use App\Containers\CommunitySection\Organization\UI\API\Requests\RegistrationOrganizationRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class RegistrationOrganizationController extends ApiController
{
    /**
     * @param RegistrationOrganizationRequest $request
     * @param RegistrationOrganizationAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws Throwable
     * @throws UnknownProperties
     */
    public function __invoke(
        RegistrationOrganizationRequest $request,
        RegistrationOrganizationAction $action
    ): JsonResponse {
        $organization = $action->run($request->getDto());
        return Response::create(
            $organization,
            $request->getTransformer()
        )->created();
    }
}
