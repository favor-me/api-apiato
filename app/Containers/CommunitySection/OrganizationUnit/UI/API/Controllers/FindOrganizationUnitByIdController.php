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
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function __invoke(
        FindOrganizationUnitByIdRequest $request,
        FindOrganizationUnitByIdAction $action
    ): JsonResponse {
        return $this->json(
            $this->transform(
                $action->run($request->id),
                $request->getTransformer()
            )
        );
    }
}
