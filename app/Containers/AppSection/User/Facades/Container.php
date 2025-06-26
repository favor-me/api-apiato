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

namespace App\Containers\AppSection\User\Facades;

use App\Containers\AppSection\User\Foundation\User;
use App\Ship\Facades\SectionContainerFacade;

final class Container extends SectionContainerFacade
{
    protected static function getFacadeAccessor(): string
    {
        return User::class;
    }
}
