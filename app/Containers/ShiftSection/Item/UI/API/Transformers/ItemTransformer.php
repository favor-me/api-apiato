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

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformerManager;
use App\Containers\OrderSection\Order\UI\API\Transformers\OrderTransformerManager;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Shift\UI\API\Transformers\ShiftTransformerManager;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item as ResourceItem;
use League\Fractal\Resource\NullResource;

class ItemTransformer extends Transformer
{
    protected array $availableIncludes = [
        CREATOR,
        Item::SHIFT,
        Item::ORDER
    ];

    public function transform(ItemModel $item): array
    {
        return [
            OBJECT => $item->getResourceKey(),
            ID => $item->getHashedKey(),
            Item::SHIFT_ID => $item->getHashedKey(Item::SHIFT_ID),
            Item::ORDER_ID => $item->getHashedKey(Item::ORDER_ID),
            Item::TYPE => $item->type->toArray(),
            Item::VALUE => $this->money($item->value),
            Item::DESCRIPTION => $item->description,
            CREATED_BY => $item->getHashedKey(CREATED_BY),
            CREATED_AT => $this->time($item->created_at),
            UPDATED_AT => $this->time($item->updated_at)
        ];
    }

    protected function includeCreator(ItemModel $item): ResourceItem|NullResource
    {
        return $this->nullOrItem($item->creator, (new UserTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeShift(ItemModel $item): ResourceItem
    {
        return $this->item($item->shift, (new ShiftTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeOrder(ItemModel $item): ResourceItem|NullResource
    {
        return $this->nullOrItem($item->order, (new OrderTransformerManager())->getDefaultOrAdmin());
    }
}
