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

namespace App\Ship\Database\Eloquent\Concerns;

trait HasStartFinishAt
{
    public function getFinishAtAttribute($value): string
    {
        return $this->removeSeconds($value);
    }

    public function getStartAtAttribute($value): string
    {
        return $this->removeSeconds($value);
    }

    /**
     * @param string $value Example hh:mm:ss
     * @return string
     */
    protected function removeSeconds($value): string
    {
        $details = explode(':', $value);
        if (count($details) > 2) {
            array_pop($details);
        }

        return implode(':', $details);
    }
}
