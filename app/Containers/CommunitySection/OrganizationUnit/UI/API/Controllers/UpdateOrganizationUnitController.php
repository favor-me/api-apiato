<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\OrganizationUnit\Actions\UpdateOrganizationUnitAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\UpdateOrganizationUnitRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrganizationUnitController extends ApiController
{
    /**
     * @param UpdateOrganizationUnitRequest $request
     * @param UpdateOrganizationUnitAction $action
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(UpdateOrganizationUnitRequest $request, UpdateOrganizationUnitAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run($request->getDto()),
                $request->getTransformer()
            )
        );
    }
}
