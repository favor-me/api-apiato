<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelEvent\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\HistorySection\ModelEvent\Actions\GetAllModelEventTypesAction;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;
use App\Containers\HistorySection\ModelEvent\UI\API\Requests\GetAllModelEventTypesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class GetAllModelEventTypesController extends ApiController
{
    /**
     * @param GetAllModelEventTypesRequest $request
     * @param GetAllModelEventTypesAction $action
     * @return JsonResponse
     * @throws InvalidTransformerException
     */
    public function __invoke(GetAllModelEventTypesRequest $request, GetAllModelEventTypesAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run(),
                $request->getTransformer(),
                [],
                [],
                ModelEventType::RESOURCE_KEY
            )
        );
    }
}
