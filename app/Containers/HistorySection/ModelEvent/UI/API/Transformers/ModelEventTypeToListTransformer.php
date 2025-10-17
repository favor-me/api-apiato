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

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;

class ModelEventTypeToListTransformer extends ModelEventTypeTransformer
{
    public function transform(ModelEventType $eventType): array
    {
        return [
            'title' => $eventType->getName(),
            'value' => $eventType::getType()
        ];
    }
}
