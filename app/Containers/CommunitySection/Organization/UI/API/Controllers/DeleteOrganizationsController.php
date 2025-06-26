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

use App\Containers\CommunitySection\Organization\Actions\DeleteOrganizationsAction;
use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Containers\CommunitySection\Organization\UI\API\Requests\DeleteOrganizationsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteOrganizationsController extends ApiController
{
    /**
     * @param DeleteOrganizationsRequest $request
     * @param DeleteOrganizationsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(DeleteOrganizationsRequest $request, DeleteOrganizationsAction $action): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
