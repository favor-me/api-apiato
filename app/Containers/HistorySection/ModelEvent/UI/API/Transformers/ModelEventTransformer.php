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

namespace App\Containers\HistorySection\ModelEvent\UI\API\Transformers;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Ship\Parents\Transformers\Transformer;

class ModelEventTransformer extends Transformer
{
    public function transform(ModelEvent $modelEvent): array
    {
        return [
            OBJECT => $modelEvent->getResourceKey(),
            ID => $modelEvent->getHashedKey(),
            BaseModelEvent::TYPE => $modelEvent->type,
            BaseModelEvent::MODEL => $modelEvent->model,
            BaseModelEvent::MODEL_ID => $modelEvent->getHashedKey(BaseModelEvent::MODEL_ID),
            BaseModelEvent::DATA => $modelEvent->data,
            BaseModelEvent::DATA_CHANGES => $modelEvent->data_changes,
            CREATED_AT => $this->nullOrTimestamp($modelEvent->created_at),
            UPDATED_AT => $this->nullOrTimestamp($modelEvent->updated_at)
        ];
    }
}
