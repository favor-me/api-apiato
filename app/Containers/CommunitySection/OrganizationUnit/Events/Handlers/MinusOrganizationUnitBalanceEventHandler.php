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

namespace App\Containers\CommunitySection\OrganizationUnit\Events\Handlers;

use App\Containers\CommunitySection\OrganizationUnit\Events\MinusOrganizationUnitBalanceEvent;
use App\Containers\CommunitySection\OrganizationUnit\History\Events\MinusOrganizationUnitBalanceEvent as HistoryEvent;
use App\Containers\HistorySection\ModelEvent\Exceptions\NotFoundModelEventTypeException;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventManager;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Events\Event;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MinusOrganizationUnitBalanceEventHandler extends Event
{
    /**
     * @param MinusOrganizationUnitBalanceEvent $event
     * @return void
     * @throws CreateResourceFailedException
     * @throws NotFoundModelEventTypeException
     * @throws UnknownProperties
     */
    public function handle(MinusOrganizationUnitBalanceEvent $event): void
    {
        $this->writeHistory($event);
    }

    /**
     * @param MinusOrganizationUnitBalanceEvent $event
     * @return void
     * @throws CreateResourceFailedException
     * @throws NotFoundModelEventTypeException
     * @throws UnknownProperties
     */
    protected function writeHistory(MinusOrganizationUnitBalanceEvent $event): void
    {
        ModelEventManager::getInstance()
            ->run(HistoryEvent::class, [
                ModelEvent::MODEL => $event->getUnit(),
                HistoryEvent::ORDER => $event->getOrder(),
                HistoryEvent::OLD_BALANCE_VALUE => $event->getOldBalanceValue(),
                HistoryEvent::MINUS_BALANCE_VALUE => $event->getMinusBalanceValue()
            ]);
    }
}
