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

use App\Containers\CommunitySection\OrganizationClient\Actions\TrashOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Requests\TrashOrganizationClientsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class TrashOrganizationClientsController extends ApiController
{
    /**
     * @param TrashOrganizationClientsRequest $request
     * @param TrashOrganizationClientsAction $action
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function __invoke(
        TrashOrganizationClientsRequest $request,
        TrashOrganizationClientsAction  $action
    ): JsonResponse
    {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleTrashed($result)
        ]);
    }
}
