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

namespace App\Containers\OrderSection\Order\Providers;

use App\Containers\OrderSection\Order\Events\Handlers\OrderCreatingEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\OrderUpdatedEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\OrderUpdatingEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\RestoredOrdersEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\TrashedOrderEventHandler;
use App\Containers\OrderSection\Order\Events\RestoredOrdersEvent;
use App\Containers\OrderSection\Order\Events\TrashedOrdersEvent;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\Parents\Providers\EventsServiceProvider as ShipEventsServiceProvider;

final class EventsServiceProvider extends ShipEventsServiceProvider
{
    protected $listen = [
        'eloquent.creating: ' . Order::class => [
            OrderCreatingEventHandler::class
        ],
        'eloquent.updating: ' . Order::class => [
            OrderUpdatingEventHandler::class
        ],
        'eloquent.updated: ' . Order::class => [
            OrderUpdatedEventHandler::class
        ],
        TrashedOrdersEvent::class => [
            TrashedOrderEventHandler::class
        ],
        RestoredOrdersEvent::class => [
            RestoredOrdersEventHandler::class
        ]
    ];
}
