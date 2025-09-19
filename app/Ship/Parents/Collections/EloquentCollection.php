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

namespace App\Ship\Parents\Collections;

use Apiato\Core\Abstracts\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

class EloquentCollection extends Collection
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
