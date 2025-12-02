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

namespace App\Containers\OrderSection\Order\Events\Handlers;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Traits\SetCanceledAt;
use App\Containers\OrderSection\Order\Traits\SetCompletedAt;
use App\Containers\OrderSection\Order\Traits\SetCounterpartyId;
use App\Ship\Parents\Events\Event;
use Illuminate\Support\Facades\DB;

class OrderCreatingEventHandler extends Event
{
    use SetCanceledAt;
    use SetCompletedAt;
    use SetCounterpartyId;

    public function handle(OrderModel $order): void
    {
        $this->setOid($order);
        $this->setCompletedAt($order);
        $this->setCanceledAt($order);
        $this->setCounterpartyId($order);
    }

    protected function setOid(OrderModel $order): void
    {
        $lastOid = DB::table($order::TABLE)
            ->where(Order::ORGANIZATION_ID, $order->organization_id)
            ->max(Order::OID);

        $order->setAttribute(Order::OID, (int)$lastOid + 1);
    }
}
