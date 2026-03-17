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

namespace App\Containers\HistorySection\ModelNote\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\HistorySection\ModelEvent\UI\API\Transformers\ModelEventTransformer;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;

class ModelNoteTransformer extends Transformer
{
    protected array $availableIncludes = [
        CREATED_BY
    ];

    protected array $defaultIncludes = [
        ModelNote::INCLUDE_EVENT
    ];

    public function transform(ModelNoteModel $modelNote): array
    {
        return [
            OBJECT => $modelNote->getResourceKey(),
            ID => $modelNote->getHashedKey(),
            ModelNote::TYPE => $modelNote->getType()->toArray(),
            ModelNote::MODEL => $modelNote->model,
            ModelNote::MODEL_ID => $modelNote->getHashedKey(ModelNote::MODEL_ID),
            ModelNote::EVENT_ID => $modelNote->getHashedKey(ModelNote::EVENT_ID),
            PARAMS => $this->transformParams($modelNote),
            CREATED_BY => $modelNote->getHashedKey(CREATED_BY),
            CREATED_AT => $this->nullOrTimeObject($modelNote->created_at)
        ];
    }

    protected function transformParams(ModelNoteModel $modelNote): array
    {
        $type = $modelNote->getType();
        return $type->getTransformerParams($modelNote->params);
    }

    protected function includeCreatedBy(ModelNoteModel $modelNote): Item|Primitive
    {
        return $this->primitiveNullOrItem($modelNote->createdBy, new UserTransformer());
    }

    protected function includeEvent(ModelNoteModel $modelNote): Item|Primitive
    {
        return $this->primitiveNullOrItem($modelNote->event, new ModelEventTransformer());
    }
}
