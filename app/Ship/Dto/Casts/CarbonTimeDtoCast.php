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

namespace App\Ship\Dto\Casts;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Caster;

class CarbonTimeDtoCast implements Caster
{
    /**
     * @param mixed $value
     * @return Carbon
     */
    public function cast(mixed $value): Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        return Carbon::createFromTimeString($value);
    }
}
