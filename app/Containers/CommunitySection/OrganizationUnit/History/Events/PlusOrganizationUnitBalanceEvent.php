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
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;

/**
 * @method null|OrganizationUnitModel getModelData()
 */
class PlusOrganizationUnitBalanceEvent extends OrganizationUnitEvent
{
    public const OLD_BALANCE_VALUE = 'addBalanceValue';

    public function getDataChanges(): array
    {
        return [
            OrganizationUnit::BALANCE => $this->getModelData()->balance
        ];
    }

    public function getData(): array
    {
        return [
            OrganizationUnit::BALANCE => $this->data->get(self::OLD_BALANCE_VALUE)
        ];
    }

    public function getModelNoteTypeParams(): array
    {
        return [
            SystemMessageModelNoteType::PARAM_KEY_MESSAGE => $this->getModelNoteMessage()
        ];
    }

    protected function getModelNoteMessage(): string
    {
        return Container::transFullKey('history.' . self::getType() . '.note_message');
    }
}
