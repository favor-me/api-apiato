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

namespace App\Containers\AppSection\UserDevice\Traits;

use App\Containers\AppSection\UserDevice\Facades\Container;
use App\Ship\Collections\ValidationRulesCollection;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;

trait HasUserDeviceValidationRules
{
    public function getUserDeviceIdValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . ID));
    }

    public function getUserDeviceTokenValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . BaseUserDevice::TOKEN));
    }

    public function getUserDeviceModelValidationRules(): ValidationRulesCollection
    {
        return validation_rules(Container::getConfig('rules.' . BaseUserDevice::MODEL));
    }
}
