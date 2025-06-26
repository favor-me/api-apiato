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

namespace App\Ship\Utils;

use InvalidArgumentException;

class WeekDay
{
    public const MAX_NUMBER = 6;
    public const MIN_NUMBER = 0;
    public const NO_TIME = '00:00';

    protected int $number;

    public function __construct(int $number)
    {
        if (!$this::check($number)) {
            throw new InvalidArgumentException(
                __('ship::exception.invalid_week_day')
            );
        }

        $this->number = $number;
    }

    public static function check(int $number): bool
    {
        return !($number < self::MIN_NUMBER || $number > self::MAX_NUMBER);
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}
