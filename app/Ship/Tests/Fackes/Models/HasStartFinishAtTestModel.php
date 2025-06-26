<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Tests\Fackes\Models;

use App\Ship\Database\Eloquent\Concerns\HasStartFinishAt;
use App\Ship\Parents\Models\Model;

/**
 * @property string $start_at
 * @property string $finish_at
 */
class HasStartFinishAtTestModel extends Model
{
    use HasStartFinishAt;

    protected $fillable = [
        'start_at',
        'finish_at'
    ];
}
