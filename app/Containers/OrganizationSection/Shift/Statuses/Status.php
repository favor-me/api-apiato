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

namespace App\Containers\OrganizationSection\Shift\Statuses;

use App\Containers\OrganizationSection\Shift\Facades\Container;
use App\Ship\Foundation\Manager\AbstractItem;

abstract class Status extends AbstractItem
{
    public function getTitle(): string
    {
        return (string)Container::trans('container.status.' . $this->getName() . '.title');
    }

    public function getColor(): string
    {
        return '#9E9E9E';
    }

    public function toArray(): array
    {
        return parent::toArray() +
            [
                'color' => $this->getColor()
            ];
    }

    protected function itemPrefix(): string
    {
        return Manager::PREFIX;
    }
}
