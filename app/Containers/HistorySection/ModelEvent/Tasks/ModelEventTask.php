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

namespace App\Containers\HistorySection\ModelEvent\Tasks;

use App\Containers\HistorySection\ModelEvent\Data\Repositories\ModelEventRepository;
use App\Ship\Parents\Tasks\Task;

abstract class ModelEventTask extends Task
{
    public function __construct(
        protected ModelEventRepository $repository
    ) {
    }
}
