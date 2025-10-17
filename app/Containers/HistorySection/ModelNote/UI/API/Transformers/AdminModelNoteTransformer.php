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

namespace App\Containers\HistorySection\ModelNote\UI\API\Transformers;

use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;

final class AdminModelNoteTransformer extends ModelNoteTransformer
{
    public function transform(ModelNote $modelNote): array
    {
        return parent::transform($modelNote) +
            [
                $this->realKey(ID) => $modelNote->id,
                $this->realKey(BaseModelNote::MODEL_ID) => $modelNote->model_id,
                $this->realKey(BaseModelNote::EVENT_ID) => $modelNote->event_id
            ];
    }
}
