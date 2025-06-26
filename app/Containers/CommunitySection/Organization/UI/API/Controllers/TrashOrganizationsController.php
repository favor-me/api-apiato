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

use App\Containers\CommunitySection\Organization\Actions\TrashOrganizationsAction;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Requests\TrashOrganizationsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class TrashOrganizationsController extends ApiController
{
    /**
     * @param TrashOrganizationsRequest $request
     * @param TrashOrganizationsAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(TrashOrganizationsRequest $request, TrashOrganizationsAction $action): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
