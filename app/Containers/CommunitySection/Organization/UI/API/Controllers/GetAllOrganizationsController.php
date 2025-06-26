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

namespace App\Containers\CommunitySection\Organization\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\Organization\Actions\GetAllOrganizationsAction;
use App\Containers\CommunitySection\Organization\Actions\GetTotalOrganizationsAction;
use App\Containers\CommunitySection\Organization\UI\API\Requests\GetAllOrganizationsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllOrganizationsController extends ApiController
{
    /**
     * @param GetAllOrganizationsRequest $request
     * @param GetAllOrganizationsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(GetAllOrganizationsRequest $request, GetAllOrganizationsAction $action): JsonResponse
    {
        $models = $action->run($request->isOnlyTrashed());
        $total = app(GetTotalOrganizationsAction::class)->run();

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
