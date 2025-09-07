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

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\OrganizationClient\Actions\UpdateOrganizationClientAction;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Requests\UpdateOrganizationClientRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrganizationClientController extends ApiController
{
    /**
     * @param UpdateOrganizationClientRequest $request
     * @param UpdateOrganizationClientAction $action
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(
        UpdateOrganizationClientRequest $request,
        UpdateOrganizationClientAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->ok();
    }
}
