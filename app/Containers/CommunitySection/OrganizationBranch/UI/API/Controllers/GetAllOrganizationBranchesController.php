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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\OrganizationBranch\Actions\GetAllOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests\GetAllOrganizationBranchesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationBranchesController extends ApiController
{
    /**
     * @param GetAllOrganizationBranchesRequest $request
     * @param GetAllOrganizationBranchesAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOrganizationBranchesRequest $request,
        GetAllOrganizationBranchesAction $action
    ): JsonResponse
    {
        $models = $action->run(
            $request->isOnlyTrashed(),
            $request->getLimit()
        );
        return $this->json(
            $this->transform(
                $models,
                $request->getTransformer()
            )
        );
    }
}
