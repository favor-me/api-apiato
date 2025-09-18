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

namespace App\Ship\Providers;

use App\Containers\Vendor\Unit\UI\API\Requests\GetAllUnitsRequest;
use App\Ship\Events\Handlers\GetAllUnitsRequestEventHandler;
use App\Ship\Events\Handlers\ModelCreatingEventHandler;
use App\Ship\Events\Handlers\ModelUpdatingEventHandler;
use App\Ship\Parents\Providers\EventsServiceProvider as BaseEventsServiceProvider;

class EventsServiceProvider extends BaseEventsServiceProvider
{
    protected $listen = [
        'request.initialize: ' . GetAllUnitsRequest::class => [
            GetAllUnitsRequestEventHandler::class
        ],
        'eloquent.creating:*' => [
            ModelCreatingEventHandler::class
        ],
        'eloquent.updating:*' => [
            ModelUpdatingEventHandler::class
        ]
    ];
}
