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

namespace App\Ship\Database\Eloquent;

use Illuminate\Database\Eloquent\Collection as BaseEloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseEloquentCollection
{
    public function getHashedKeys(string $key = ID): BaseCollection
    {
        $keys = array_map(
            fn(Model $model) => $model->getHashedKey($key),
            $this->items
        );

        return collect($keys);
    }
}
