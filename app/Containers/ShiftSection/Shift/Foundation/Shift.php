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

namespace App\Containers\ShiftSection\Shift\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Shift extends SectionContainer
{
    public const string FINISH_AT = 'finish_at';
    public const string ORGANIZATION = 'organization';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string ORGANIZATION_BRANCH = 'organization_branch';
    public const string ORGANIZATION_BRANCH_ID = 'organization_branch_id';
    public const string MONEY = 'money';
    public const string CREATOR = 'creator';
    public const string ITEMS = 'items';
    public const string ORDERS = 'orders';
    public const string EXCLUDE_ORGANIZATION_BRANCH = 'exclude_organization_branch';
    public const string CONFIRMED_BY = 'confirmed_by';
    public const string START_AT = 'start_at';
    public const string CONFIRMED_AT = 'confirmed_at';
    public const string PAYMENT_AT = 'payment_at';
    public const string PAYMENT = 'payment';
    public const string STATUS = 'status';

    protected string $gender = 'female';
    protected string $apiBaseUri = 'shifts';

    public function transMultipleConfirmed(int $count): string
    {
        return trans_choice('action.confirmed_multiple', $count, [
            'confirms' => $this->transLowerChoice('core.' . $this->gender . '_confirmed', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }

    public function transMultiplePaid(int $count): string
    {
        return trans_choice('action.paid_multiple', $count, [
            'paid' => $this->transLowerChoice('core.' . $this->gender . '_paid', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }
}
