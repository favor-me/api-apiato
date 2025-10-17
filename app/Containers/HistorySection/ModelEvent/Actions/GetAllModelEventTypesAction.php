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

namespace App\Containers\HistorySection\ModelEvent\Actions;

use App\Containers\HistorySection\ModelEvent\Tasks\GetAllModelEventTypesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllModelEventTypesAction extends Action
{
    public function run(): Collection
    {
        return app(GetAllModelEventTypesTask::class)->run();
    }
}
