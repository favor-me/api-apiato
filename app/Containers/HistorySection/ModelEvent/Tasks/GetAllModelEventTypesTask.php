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

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventManager;
use Illuminate\Support\Collection;

class GetAllModelEventTypesTask extends ModelEventTask
{
    public function run(): Collection
    {
        return ModelEventManager::getInstance()->all();
    }
}
