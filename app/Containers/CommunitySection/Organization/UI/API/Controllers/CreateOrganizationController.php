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
use App\Containers\CommunitySection\Organization\Actions\CreateOrganizationAction;
use App\Containers\CommunitySection\Organization\UI\API\Requests\CreateOrganizationRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationController extends ApiController
{
    /**
     * @param CreateOrganizationRequest $request
     * @param CreateOrganizationAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     */
    public function __invoke(CreateOrganizationRequest $request, CreateOrganizationAction $action): JsonResponse
    {
        $model = $action->run($request->getDto());
        return $this->created(
            $this->transform(
                $model,
                $request->getTransformer()
            )
        );
    }
}
