<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\UI\API\Requests\DeleteOwnUsersRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteOwnUsersController extends ApiController
{
    /**
     * @param DeleteOwnUsersRequest $request
     * @param DeleteUserAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(DeleteOwnUsersRequest $request, DeleteUserAction $action): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
