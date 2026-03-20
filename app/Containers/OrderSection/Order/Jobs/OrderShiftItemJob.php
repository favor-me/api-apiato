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

namespace App\Containers\OrderSection\Order\Jobs;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Parents\Jobs\Job;

abstract class OrderShiftItemJob extends Job
{
    protected float $orderProfitPercent = 0;

    public function __construct(
        protected OrderModel $order
    ) {
        if ($this->order->shift_id) {
            $this->orderProfitPercent = (float)$this->order->shift->creator->shift_params->get(
                User::SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT
            );
        }
    }

    public function __invoke(): void
    {
        if ($this->order->shift_id) {
            if ($this->orderProfitPercent > ZERO) {
                $this->run();
            }
        }
    }

    abstract protected function run(): void;
}
