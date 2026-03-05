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

namespace App\Containers\ShiftSection\Item\Validation\Rules;

use App\Containers\ShiftSection\Item\Facades\Container;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\DB;

class IsOrganizationShiftItemRule extends ValidationRule
{
    public function __construct(
        protected readonly int $organizationId
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table(ItemModel::TABLE)
            ->leftJoin(
                ShiftModel::TABLE,
                Item::SHIFT_ID,
                '=',
                ShiftModel::TABLE . '.' . ID
            )
            ->where(ItemModel::TABLE . '.' . ID, $value)
            ->where(ShiftModel::TABLE . '.' . Shift::ORGANIZATION_ID, $this->organizationId)
            ->exists();

        if (!$exists) {
            $fail(__('validation.custom.ids.*.exists'));
        }
    }
}
