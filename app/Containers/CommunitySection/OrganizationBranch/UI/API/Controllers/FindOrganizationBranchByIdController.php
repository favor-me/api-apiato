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

use App\Containers\CommunitySection\OrganizationBranch\Actions\FindOrganizationBranchByIdAction;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests\FindOrganizationBranchByIdRequest;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class FindOrganizationBranchByIdController extends ApiController
{
    /**
     * @param FindOrganizationBranchByIdRequest $request
     * @param FindOrganizationBranchByIdAction $action
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws NotFoundException
     */
    public function __invoke(FindOrganizationBranchByIdRequest $request, FindOrganizationBranchByIdAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run($request->id),
                $request->getTransformer()
            )
        );
    }
}
