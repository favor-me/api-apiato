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

use App\Ship\Parents\Providers\MainServiceProvider as ShipMainServiceProvider;

final class MainServiceProvider extends ShipMainServiceProvider
{
    public array $serviceProviders = [
        EventServiceProvider::class
    ];
}
