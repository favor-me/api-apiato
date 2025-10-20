<?php

namespace App\Containers\HistorySection\ModelEvent\Contracts;

use App\Containers\HistorySection\ModelEvent\Dto\CreateModelEventDto;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;

interface CreateModelEventActionContract
{
    public function run(CreateModelEventDto $dto): ModelEvent;
}
