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

namespace App\Containers\AccountingSection\Contract\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Facades\Response;
use App\Containers\AccountingSection\Contract\Actions\GetAllContractsAction;
use App\Containers\AccountingSection\Contract\UI\API\Requests\GetAllContractsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllContractsController extends ApiController
{
    /**
     * @param GetAllContractsRequest $request
     * @param GetAllContractsAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllContractsRequest $request,
        GetAllContractsAction $action
    ): JsonResponse {
        $models = $action->run($request->isOnlyTrashed());

        return Response::create(
            $models,
            $request->getTransformer()
        )->ok();
    }
}
