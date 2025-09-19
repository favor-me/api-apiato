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

namespace App\Containers\OrderSection\Order\Tasks;

use App\Containers\OrderSection\Order\Data\Repositories\OrderRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Traits\Task\OnlyTrashed;

abstract class OrderTask extends Task
{
    use OnlyTrashed;

    public function __construct(
        protected OrderRepository $repository
    )
    {
    }
}
