<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelEvent\UI\API\Transformers;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;

class ModelEventAdminTransformer extends ModelEventTransformer
{
    public function transform(ModelEvent $modelEvent): array
    {
        return parent::transform($modelEvent) +
            [
                $this->realKey(ID) => $modelEvent->id,
                $this->realKey(BaseModelEvent::MODEL_ID) => $modelEvent->model_id
            ];
    }
}
