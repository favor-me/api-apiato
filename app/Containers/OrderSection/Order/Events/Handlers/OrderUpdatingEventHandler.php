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

use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Traits\SetCanceledAt;
use App\Containers\OrderSection\Order\Traits\SetCompletedAt;
use App\Containers\OrderSection\Order\Traits\SetCounterpartyId;
use App\Ship\Parents\Events\Event;

class OrderUpdatingEventHandler extends Event
{
    use SetCanceledAt;
    use SetCompletedAt;
    use SetCounterpartyId;

    public function handle(OrderModel $order): void
    {
        $this->setCompletedAt($order);
        $this->setCanceledAt($order);
        $this->setCounterpartyId($order);
    }
}
