<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelNote\Facades;

use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Ship\Facades\SectionContainerFacade;

final class Container extends SectionContainerFacade
{
    protected static function getFacadeAccessor(): string
    {
        return ModelNote::class;
    }
}
