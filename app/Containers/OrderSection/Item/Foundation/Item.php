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
    public const string AMOUNT = 'amount';
    public const string CLIENT_PRICE = 'client_price';
    public const string UNIT_CLIENT_PRICE = 'unit_client_price';
    public const string IS_MANUAL_CLIENT_PRICE = 'is_manual_client_price';
    public const string COST_PRICE = 'cost_price';
    public const string NAME = 'name';
    public const string ORDER_ID = 'order_id';
    public const string SKU = 'sku';
    public const string TYPE = 'type';
    public const string TYPE_MAX_LENGTH = '15';
    public const string UNIT_ID = 'unit_id';

    protected string $gender = 'female';

    protected string $apiBaseUri = 'order/items';
}
