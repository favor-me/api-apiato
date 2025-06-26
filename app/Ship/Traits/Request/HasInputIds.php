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

namespace App\Ship\Traits\Request;

/**
 * @property mixed $ids
 */
trait HasInputIds
{
    public function getIds(bool $input = false): array
    {
        return !$input ? (array) $this->ids : (array) $this->get('ids');
    }
}
