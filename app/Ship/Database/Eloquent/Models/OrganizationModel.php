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

namespace App\Ship\Database\Eloquent\Models;

use App\Ship\Database\Eloquent\Scopes\AuthOrganizationUserScope;
use App\Ship\Parents\Models\Model;

abstract class OrganizationModel extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new AuthOrganizationUserScope());
    }
}
