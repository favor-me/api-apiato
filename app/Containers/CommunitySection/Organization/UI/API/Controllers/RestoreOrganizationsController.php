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

use App\Containers\CommunitySection\Organization\Actions\RestoreOrganizationsAction;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Requests\RestoreOrganizationsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreOrganizationsController extends ApiController
{
    /**
     * @param RestoreOrganizationsRequest $request
     * @param RestoreOrganizationsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(RestoreOrganizationsRequest $request, RestoreOrganizationsAction $action): JsonResponse
    {
        $result = $action->run($request->getIds());

        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
