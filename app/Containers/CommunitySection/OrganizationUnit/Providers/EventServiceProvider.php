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

namespace App\Containers\CommunitySection\OrganizationUnit\Providers;

use App\Containers\CommunitySection\OrganizationUnit\Events\Handlers\PlusOrganizationUnitBalanceEventHandler;
use App\Containers\CommunitySection\OrganizationUnit\Events\PlusOrganizationUnitBalanceEvent;
use App\Ship\Parents\Providers\EventsServiceProvider as ShipEventServiceProvider;

final class EventServiceProvider extends ShipEventServiceProvider
{
    protected $listen = [
        PlusOrganizationUnitBalanceEvent::class => [
            PlusOrganizationUnitBalanceEventHandler::class
        ]
    ];
}
