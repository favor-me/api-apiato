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

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\OrganizationUnit\Actions\GetAllOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\Actions\GetTotalOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\GetAllOrganizationUnitsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationUnitsController extends ApiController
{
    /**
     * @param GetAllOrganizationUnitsRequest $request
     * @param GetAllOrganizationUnitsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(GetAllOrganizationUnitsRequest $request, GetAllOrganizationUnitsAction $action): JsonResponse
    {
        $models = $action->run($request->isOnlyTrashed());
        $total = app(GetTotalOrganizationUnitsAction::class)->run();

        return $this->json(
            $this->transform(
                $models,
                $request->getTransformer(),
                [],
                $this->getBaseMetaResponseForGetAllAction(__CLASS__, $total)
            )
        );
    }
}
