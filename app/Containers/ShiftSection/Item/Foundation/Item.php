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

namespace App\Containers\ShiftSection\Item\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Item extends SectionContainer
{
    public const string DESCRIPTION = 'description';
    public const string ORDER_ID = 'order_id';
    public const string ORDER = 'order';
    public const string SHIFT_ID = 'shift_id';
    public const string SHIFT = 'shift';
    public const string TYPE = 'type';
    public const int TYPE_MAX_LENGTH = 50;
    public const string SYSTEM_NOTE = 'system_note';
    public const string VALUE = 'value';

    protected string $gender = 'female';

    protected string $apiBaseUri = 'shift/items';
}
