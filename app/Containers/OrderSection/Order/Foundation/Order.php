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

namespace App\Containers\OrderSection\Order\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Order extends SectionContainer
{
    public const CLIENT_ID = 'client_id';
    public const COMMENT = 'comment';
    public const OID = 'oid';
    public const ORGANIZATION_ID = 'organization_id';
    public const PAYMENT_TYPE = 'payment_type';
    public const TOTAL = 'total';
    public const PROFIT = 'profit';
    public const CREATOR = 'creator';
    public const CLIENT = 'client';
    public const UPDATER = 'updater';
    public const ORGANIZATION = 'organization';

    protected string $apiBaseUri = 'order/orders';
}
