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

namespace App\Containers\CommunitySection\OrganizationUnit\History\Events;

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteType;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteTypeManager;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;

abstract class OrganizationUnitEvent extends ModelEventType
{
    public function getGroup(): string
    {
        return Container::getName();
    }

    public function getModelNoteType(): ModelNoteType
    {
        return ModelNoteTypeManager::getInstance()
            ->get(SystemMessageModelNoteType::class);
    }

    public function getName(): string
    {
        return Container::trans('history.' . self::getType() . '.name');
    }
}
