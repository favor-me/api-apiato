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

namespace App\Containers\OrderSection\Order\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformer;
use App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers\OrganizationClientTransformer;
use App\Containers\OrderSection\Item\UI\API\Transformers\ItemTransformer;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Status\UI\API\Transformers\StatusTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Primitive;

class OrderTransformer extends Transformer
{
    protected array $defaultIncludes = [
        Order::STATUS,
        Order::ITEMS
    ];

    protected array $availableIncludes = [
        Order::CLIENT,
        Order::CREATOR,
        Order::UPDATER,
        Order::ORGANIZATION
    ];

    public function transform(OrderModel $order): array
    {
        return [
            OBJECT => $order->getResourceKey(),
            ID => $order->getHashedKey(),
            Order::ORGANIZATION_ID => $order->getHashedKey(Order::ORGANIZATION_ID),
            Order::OID => $order->oid,
            Order::STATUS_ID => $order->getHashedKey(Order::STATUS_ID),
            Order::PAYMENT_TYPE => $order->payment_type->toArray(),
            Order::TOTAL => $this->money($order->total),
            Order::PROFIT => $this->money($order->profit),
            Order::COMMENT => $order->comment,
            Order::CLIENT_ID => $order->getHashedKey(Order::CLIENT_ID),
            CREATED_BY => $order->getHashedKey(CREATED_BY),
            UPDATED_BY => $order->getHashedKey(UPDATED_BY),
            CREATED_AT => $this->time($order->created_at),
            UPDATED_AT => $this->time($order->updated_at),
            DELETED_AT => $this->time($order->deleted_at)
        ];
    }

    protected function includeOrganization(OrderModel $order): Item
    {
        return $this->item($order->organization, new OrganizationTransformer());
    }

    protected function includeClient(OrderModel $order): Item|Primitive
    {
        return $this->primitiveNullOrItem($order->client, new OrganizationClientTransformer());
    }

    protected function includeCreator(OrderModel $order): Item|Primitive
    {
        return $this->primitiveNullOrItem($order->creator, new UserTransformer());
    }

    protected function includeUpdater(OrderModel $order): Item|Primitive
    {
        return $this->primitiveNullOrItem($order->updater, new UserTransformer());
    }

    protected function includeStatus(OrderModel $order): Item|Primitive
    {
        return $this->primitiveNullOrItem($order->status, new StatusTransformer());
    }

    protected function includeItems(OrderModel $order): Collection|NullResource
    {
        return $this->collection($order->items, new ItemTransformer());
    }
}
