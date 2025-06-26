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

namespace App\Containers\AppSection\UserDevice\Data\Repositories;

use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Repositories\Repository;

final class UserDeviceRepository extends Repository
{
    public function model(): string
    {
        return UserDevice::class;
    }
}
