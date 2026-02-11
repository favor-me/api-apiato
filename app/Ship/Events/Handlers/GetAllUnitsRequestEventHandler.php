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

namespace App\Ship\Events\Handlers;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Events\RequestInitializeEvent;
use App\Ship\Parents\Events\Event as EventHandler;

class GetAllUnitsRequestEventHandler extends EventHandler
{
    public function handle(RequestInitializeEvent $event): void
    {
        $event
            ->getRequest()
            ->setAccess([
                Role::ORGANIZATION_OWNER,
                Role::ORGANIZATION_WORKER
            ]);
    }
}
