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

namespace App\Containers\AccountingSection\Contract\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Contract extends SectionContainer
{
    public const string COUNTERPARTY_ID = 'counterparty_id';
    public const string COUNTERPARTY = 'counterparty';
    public const string FINISH_AT = 'finish_at';
    public const string NAME = 'name';
    public const string NUMBER = 'number';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string ORGANIZATION = 'organization';
    public const string START_AT = 'start_at';

    protected string $apiBaseUri = 'accounting/contracts';
}
