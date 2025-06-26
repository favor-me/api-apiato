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

use App\Ship\Database\Eloquent\Concerns\HasUpdatedBy;
use App\Ship\Parents\Models\Model;

/**
 * @property mixed $updated_by
 */
class HasUpdatedByTestModel extends Model
{
    use HasUpdatedBy;
}
