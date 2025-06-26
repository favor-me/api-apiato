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

namespace App\Ship\Parents\Models;

use App\Ship\Database\Eloquent\Collection;
use Apiato\Core\Abstracts\Models\Model as AbstractModel;

/**
 * Class Model
 *
 * @package App\Ship\Parents\Models
 */
abstract class Model extends AbstractModel
{
    /**
     * Reload default eloquent collection instance to default ship eloquent collection.
     *
     * @param   array $models
     *
     * @return  Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }
}
