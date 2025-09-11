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

use App\Containers\CommunitySection\OrganizationUnit\Actions\RestoreOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\RestoreOrganizationUnitsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreOrganizationUnitsController extends ApiController
{
    /**
     * @param RestoreOrganizationUnitsRequest $request
     * @param RestoreOrganizationUnitsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RestoreOrganizationUnitsRequest $request,
        RestoreOrganizationUnitsAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
