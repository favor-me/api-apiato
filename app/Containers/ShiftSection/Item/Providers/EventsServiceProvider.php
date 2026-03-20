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

namespace App\Containers\ShiftSection\Item\Providers;

use App\Containers\ShiftSection\Item\Events\Handlers\ItemCreatedEventHandler;
use App\Containers\ShiftSection\Item\Events\Handlers\ItemUpdatedEventHandler;
use App\Containers\ShiftSection\Item\Models\Item;
use App\Ship\Parents\Providers\EventsServiceProvider as ShipEventsServiceProvider;

final class EventsServiceProvider extends ShipEventsServiceProvider
{
    protected $listen = [
        'eloquent.created: ' . Item::class => [
            ItemCreatedEventHandler::class
        ],
        'eloquent.updated: ' . Item::class => [
            ItemUpdatedEventHandler::class
        ]
    ];
}
