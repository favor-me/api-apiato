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

use App\Containers\HistorySection\ModelEvent\Dto\CreateModelEventDto;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;

class CreateModelEventTask extends ModelEventTask
{
    /**
     * @param CreateModelEventDto $dto
     * @return ModelEvent
     * @throws CreateResourceFailedException
     */
    public function run(CreateModelEventDto $dto): ModelEvent
    {
        try {
            return $this->repository->create($dto->toData());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }
    }
}
