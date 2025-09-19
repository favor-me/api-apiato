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

namespace App\Containers\OrderSection\Item\UI\API\Transformers;

use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Ship\Parents\Transformers\Transformer;

class ItemTransformer extends Transformer
{
    public function transform(ItemModel $item): array
    {
        return [
            OBJECT => $item->getResourceKey(),
            ID => $item->getHashedKey(),
            Item::ORDER_ID => $item->getHashedKey(Item::ORDER_ID),
            Item::UNIT_ID => $item->getHashedKey(Item::UNIT_ID),
            Item::NAME => $item->name,
            Item::SKU => $item->sku,
            Item::COST_PRICE => $item->cost_price,
            Item::CLIENT_PRICE => $item->client_price,
            Item::AMOUNT => $item->amount
        ];
    }
}
