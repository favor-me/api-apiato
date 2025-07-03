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

use App\Containers\CommunitySection\OrganizationBranch\Actions\DeleteOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\Facades\Container;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests\DeleteOrganizationBranchesRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteOrganizationBranchesController extends ApiController
{
    /**
     * @param DeleteOrganizationBranchesRequest $request
     * @param DeleteOrganizationBranchesAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(DeleteOrganizationBranchesRequest $request, DeleteOrganizationBranchesAction $action): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
