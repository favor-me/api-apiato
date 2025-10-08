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

namespace App\Containers\OrderSection\Item\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Item extends SectionContainer
{
    public const AMOUNT = 'amount';
    public const CLIENT_PRICE = 'client_price';
    public const COST_PRICE = 'cost_price';
    public const NAME = 'name';
    public const ORDER_ID = 'order_id';
    public const SKU = 'sku';
    public const UNIT_ID = 'unit_id';

    protected string $gender = 'female';

    protected string $apiBaseUri = 'order/items';
}
