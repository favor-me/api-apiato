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

namespace App\Containers\OrderSection\PaymentType\Actions;

use App\Containers\OrderSection\PaymentType\Tasks\GetAllPaymentTypesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllPaymentTypesAction extends Action
{
    public function run(): Collection
    {
        return app(GetAllPaymentTypesTask::class)->run();
    }
}
