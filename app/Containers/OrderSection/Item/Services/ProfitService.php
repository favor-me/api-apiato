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

namespace App\Containers\OrderSection\Item\Services;

use App\Containers\OrderSection\Item\Models\Item;
use App\Ship\SimpleTypes\Type\Money;

class ProfitService
{
    protected Money $costPrice;
    protected Money $clientPrice;
    protected float $amount;

    public function __construct(
        int $costPrice = null,
        int $clientPrice = null,
        float $amount = 1
    ) {
        $this->amount = $amount;
        $this->costPrice = app('money')->add($costPrice);
        $this->clientPrice = app('money')->add($clientPrice);
    }

    public function fromItem(Item $item): self
    {
        $this->costPrice = $item->cost_price;
        $this->clientPrice = $item->client_price;
        $this->amount = $item->amount;
        return $this;
    }

    public function calculate(): Money
    {
        $difference = $this->clientPrice->add(-$this->costPrice->val(), true);

        if ($this->amount === 0.0) {
            return $difference;
        }

        return $difference->multiply($this->amount);
    }
}
