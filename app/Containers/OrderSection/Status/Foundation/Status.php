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

namespace App\Containers\OrderSection\Status\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Status extends SectionContainer
{
    public const IS_BASE = 'is_base';
    public const NAME = 'name';
    public const SLUG = 'slug';

    protected string $apiBaseUri = 'order/statuses';
}
