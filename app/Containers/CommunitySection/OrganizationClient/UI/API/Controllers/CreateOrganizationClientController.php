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
use App\Containers\CommunitySection\OrganizationClient\Actions\CreateOrganizationClientAction;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Requests\CreateOrganizationClientRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationClientController extends ApiController
{
    /**
     * @param CreateOrganizationClientRequest $request
     * @param CreateOrganizationClientAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function __invoke(
        CreateOrganizationClientRequest $request,
        CreateOrganizationClientAction  $action
    ): JsonResponse
    {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->created();
    }
}
