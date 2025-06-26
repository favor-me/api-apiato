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

namespace App\Containers\AppSection\UserDevice\Tasks;

use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Exception;

class TouchUserDeviceTask extends UserDeviceTask
{
    /**
     * @param UserDevice $userDevice
     * @return UserDevice
     * @throws UpdateResourceFailedException
     */
    public function run(UserDevice $userDevice): UserDevice
    {
        try {
            $userDevice->touch();
            return $userDevice->refresh();
        } catch (Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
