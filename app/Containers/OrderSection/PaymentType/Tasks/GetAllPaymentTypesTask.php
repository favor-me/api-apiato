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

namespace App\Containers\OrderSection\PaymentType\Tasks;

use App\Containers\OrderSection\PaymentType\Manager;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetAllPaymentTypesTask extends Task
{
    public function run(): Collection
    {
        return Manager::getInstance()->all();
    }
}
