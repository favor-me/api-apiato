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

namespace App\Containers\OrderSection\Item\Providers;

use App\Containers\OrderSection\Item\Events\Handlers\RepositoryDeletedItemEventHandler;
use App\Ship\Parents\Providers\EventsServiceProvider as ShipEventsServiceProvider;
use Prettus\Repository\Events\RepositoryEntityDeleted;

class EventsServiceProvider extends ShipEventsServiceProvider
{
    protected $listen = [
        RepositoryEntityDeleted::class => [
            RepositoryDeletedItemEventHandler::class
        ]
    ];
}
