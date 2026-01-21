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
    public const string CLIENT_ID = 'client_id';
    public const string COMMENT = 'comment';
    public const string CONTRACT_ID = 'contract_id';
    public const string COUNTERPARTY_ID = 'counterparty_id';
    public const string COMPLETED_AT = 'completed_at';
    public const string CANCELED_AT = 'canceled_at';
    public const string BRANCH_ID = 'branch_id';
    public const string OID = 'oid';
    public const string STATUS_ID = 'status_id';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string PAYMENT_TYPE = 'payment_type';
    public const string TOTAL = 'total';
    public const string ITEMS = 'items';
    public const string PROFIT = 'profit';
    public const string CREATOR = 'creator';
    public const string CLIENT = 'client';
    public const string UPDATER = 'updater';
    public const string CONTRACT = 'contract';
    public const string COUNTERPARTY = 'counterparty';
    public const string STATUS = 'status';
    public const string ORGANIZATION = 'organization';

    protected string $apiBaseUri = 'order/orders';
}
