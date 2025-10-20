<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\OrderSection\Order\Providers;

use App\Containers\OrderSection\Order\Events\Handlers\OrderCreatingEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\OrderUpdatedEventHandler;
use App\Containers\OrderSection\Order\Events\Handlers\OrderUpdatingEventHandler;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\Parents\Providers\EventsServiceProvider as ShipEventsServiceProvider;

class EventsServiceProvider extends ShipEventsServiceProvider
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
        ]
    ];
}
