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

namespace App\Ship\Tests\Fackes\Objects;

use Illuminate\Support\Carbon;

class TimeWindowObject
{
    public Carbon $start_at;
    public Carbon $finish_at;

    public function __construct(string $startAt, string $finishAt)
    {
        $this->start_at = Carbon::createFromTimeString($startAt);
        $this->finish_at = Carbon::createFromTimeString($finishAt);
    }
}
