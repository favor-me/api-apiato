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

namespace App\Containers\HistorySection\ModelEvent\Dto;

use App\Ship\Contracts\ToData;
use App\Ship\Dto\Dto;
use App\Ship\Traits\DtoToData;

class CreateModelEventDto extends Dto implements ToData
{
    use DtoToData;

    public string $type;
    public string $model;
    public int $model_id;
    public array $data = [];
    public ?int $created_by = null;
    public array $data_changes = [];
}
