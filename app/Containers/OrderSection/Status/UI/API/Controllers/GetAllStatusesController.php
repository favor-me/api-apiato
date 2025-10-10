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

namespace App\Containers\OrderSection\Status\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Facades\Response;
use App\Containers\OrderSection\Status\Actions\GetAllStatusesAction;
use App\Containers\OrderSection\Status\UI\API\Requests\GetAllStatusesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllStatusesController extends ApiController
{
    /**
     * @param GetAllStatusesRequest $request
     * @param GetAllStatusesAction $action
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function __invoke(
        GetAllStatusesRequest $request,
        GetAllStatusesAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->getLimit()),
            $request->getTransformer()
        )->ok();
    }
}
