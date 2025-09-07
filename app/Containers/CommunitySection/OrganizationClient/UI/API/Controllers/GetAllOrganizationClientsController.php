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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\OrganizationClient\Actions\GetAllOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Requests\GetAllOrganizationClientsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationClientsController extends ApiController
{
    /**
     * @param GetAllOrganizationClientsRequest $request
     * @param GetAllOrganizationClientsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllOrganizationClientsRequest $request,
        GetAllOrganizationClientsAction  $action
    ): JsonResponse
    {
        $models = $action->run($request->isOnlyTrashed());
        return $this->json(
            $this->transform(
                $models,
                $request->getTransformer()
            )
        );
    }
}
