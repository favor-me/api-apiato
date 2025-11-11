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

namespace App\Containers\CommunitySection\Counterparty\Countries\BankData;

class Collection
{
    protected array $elements = [];

    public function getElements(): array
    {
        return $this->elements;
    }

    public function add(Element $element): self
    {
        $this->elements[$element->getName()] = $element;
        return $this;
    }
}
