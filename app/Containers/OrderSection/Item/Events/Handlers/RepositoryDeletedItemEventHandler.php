<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\OrderSection\Item\Events\Handlers;

use App\Containers\OrderSection\Item\Models\Item;
use App\Ship\Parents\Events\Event;
use Prettus\Repository\Events\RepositoryEntityDeleted;

class RepositoryDeletedItemEventHandler extends Event
{
    public function __invoke(RepositoryEntityDeleted $event): void
    {
        if ($event->getModel() instanceof Item) {
            /** @var Item $item */
            $item = $event->getModel();
            $item->order->calculateTotal(true);
        }
    }
}
