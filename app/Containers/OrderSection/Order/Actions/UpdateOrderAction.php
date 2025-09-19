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

namespace App\Containers\OrderSection\Order\Actions;

use App\Containers\OrderSection\Order\Dto\UpdateOrderDto;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Tasks\UpdateOrderTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateOrderAction extends Action
{
    /**
     * @param UpdateOrderDto $dto
     * @return Order
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateOrderDto $dto): Order
    {
        return app(UpdateOrderTask::class)->run($dto);
    }
}
