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

use App\Containers\CommunitySection\OrganizationClient\Actions\DeleteOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Requests\DeleteOrganizationClientsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteOrganizationClientsController extends ApiController
{
    /**
     * @param DeleteOrganizationClientsRequest $request
     * @param DeleteOrganizationClientsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        DeleteOrganizationClientsRequest $request,
        DeleteOrganizationClientsAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
