<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelNote\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\HistorySection\ModelEvent\Actions\GetAllModelEventTypesByModelAction;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;
use App\Containers\HistorySection\ModelEvent\UI\API\Transformers\ModelEventTypeToListTransformer;
use App\Containers\HistorySection\ModelNote\Actions\GetAllModelNotesAction;
use App\Containers\HistorySection\ModelNote\ModelNoteManager;
use App\Containers\HistorySection\ModelNote\UI\API\Requests\GetAllModelNotesRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllModelNotesController extends ApiController
{
    /**
     * @param GetAllModelNotesRequest $request
     * @return JsonResponse
     * @throws CoreInternalErrorException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function __invoke(GetAllModelNotesRequest $request): JsonResponse
    {
        $searchModel = app('helper.search')->getSearchField('model');

        $eventTypes = app(GetAllModelEventTypesByModelAction::class)->run($searchModel);

        $orderEventTypesResponse = $this->transform(
            $eventTypes,
            new ModelEventTypeToListTransformer(),
            [],
            [],
            ModelEventType::RESOURCE_KEY
        );

        $modelNotes = app(GetAllModelNotesAction::class)->run($request->getLimit());

        return $this->json(
            $this->transform(
                $modelNotes,
                $request->getTransformer(),
                [],
                [
                    'models' => ModelNoteManager::getInstance()->toList(),
                    'event_types' => $orderEventTypesResponse['data']
                ]
            )
        );
    }
}
