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

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\Organization\Actions\UpdateOrganizationAction;
use App\Containers\CommunitySection\Organization\UI\API\Requests\UpdateOwnOrganizationRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOwnOrganizationController extends ApiController
{
    /**
     * @param UpdateOwnOrganizationRequest $request
     * @param UpdateOrganizationAction $action
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(UpdateOwnOrganizationRequest $request, UpdateOrganizationAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run($request->getDto()),
                $request->getTransformer()
            )
        );
    }
}
