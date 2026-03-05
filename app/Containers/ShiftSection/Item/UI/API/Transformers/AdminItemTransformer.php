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

namespace App\Containers\ShiftSection\Item\UI\API\Transformers;

use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;

final class AdminItemTransformer extends ItemTransformer
{
    public function transform(ItemModel $item): array
    {
        return parent::transform($item) +
            [
                $this->realKey(ID) => $item->id,
                $this->realKey(Item::SHIFT_ID) => $item->shift_id,
                $this->realKey(Item::ORDER_ID) => $item->order_id,
                $this->realKey(CREATED_BY) => $item->created_by
            ];
    }
}
