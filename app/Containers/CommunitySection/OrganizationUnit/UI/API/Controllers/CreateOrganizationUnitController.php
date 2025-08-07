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
use App\Containers\CommunitySection\OrganizationUnit\Actions\CreateOrganizationUnitAction;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests\CreateOrganizationUnitRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationUnitController extends ApiController
{
    /**
     * @param CreateOrganizationUnitRequest $request
     * @param CreateOrganizationUnitAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     */
    public function __invoke(CreateOrganizationUnitRequest $request, CreateOrganizationUnitAction $action): JsonResponse
    {
        $model = $action->run($request->getDto());
        return $this->created(
            $this->transform(
                $model,
                $request->getTransformer()
            )
        );
    }
}
