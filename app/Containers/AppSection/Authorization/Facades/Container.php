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

namespace App\Containers\AppSection\Authorization\Facades;

use App\Ship\Facades\SectionContainerFacade;
use App\Containers\AppSection\Authorization\Foundation\Authorization;

final class Container extends SectionContainerFacade
{
    protected static function getFacadeAccessor(): string
    {
        return Authorization::class;
    }
}
