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

use App\Containers\HistorySection\ModelEvent\Contracts\CreateModelEventActionContract;
use App\Containers\HistorySection\ModelEvent\Dto\CreateModelEventDto;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Tasks\CreateModelEventTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;

final class CreateModelEventAction extends Action implements CreateModelEventActionContract
{
    /**
     * @param CreateModelEventDto $dto
     * @return ModelEvent
     * @throws CreateResourceFailedException
     */
    public function run(CreateModelEventDto $dto): ModelEvent
    {
        return app(CreateModelEventTask::class)->run($dto);
    }
}
