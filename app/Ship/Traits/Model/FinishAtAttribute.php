<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Traits\Model;

use App\Ship\Eloquent\Casts\DateTimeAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait FinishAtAttribute
{
    public function finishAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => DateTimeAttribute::setFromCustomFormat($value),
            get: fn ($value) => DateTimeAttribute::get($value)
        );
    }
}
