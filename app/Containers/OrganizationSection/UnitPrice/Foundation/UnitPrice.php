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

namespace App\Containers\OrganizationSection\UnitPrice\Foundation;

use App\Ship\Foundation\SectionContainer;

final class UnitPrice extends SectionContainer
{
    public const string BALANCE = 'balance';
    public const string IS_INFINITY_BALANCE = 'is_infinity_balance';
    public const string CLIENT_PRICE = 'client_price';
    public const string COST_PRICE = 'cost_price';
    public const string MODEL = 'model';
    public const string MODEL_ID = 'model_id';
    public const string PRICE_UP = 'price_up';
    public const string UNIT_ID = 'unit_id';
    public const int PRICE_MAX_LENGTH = 200000 * 100;

    protected string $apiBaseUri = 'organization/unit-prices';
}
