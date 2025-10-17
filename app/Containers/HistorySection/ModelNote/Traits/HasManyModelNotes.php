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

namespace App\Containers\HistorySection\ModelNote\Traits;

use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Ship\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $modelNotes
 */
trait HasManyModelNotes
{
    public function modelNotes(): HasMany
    {
        return $this
            ->hasMany(ModelNoteModel::class, ModelNote::MODEL_ID, ID)
            ->where(ModelNote::MODEL, self::class)
            ->orderBy(ID, 'desc');
    }
}
