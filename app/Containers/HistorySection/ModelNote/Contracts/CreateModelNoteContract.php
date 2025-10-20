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

namespace App\Containers\HistorySection\ModelNote\Contracts;

use App\Containers\HistorySection\ModelNote\Dto\CreateModelNoteDto;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;

interface CreateModelNoteContract
{
    public function run(CreateModelNoteDto $dto): ModelNote;
}
