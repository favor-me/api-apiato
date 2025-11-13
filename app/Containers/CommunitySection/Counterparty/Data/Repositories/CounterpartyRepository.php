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

namespace App\Containers\CommunitySection\Counterparty\Data\Repositories;

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method CounterpartyModel getModel()
 */
final class CounterpartyRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        Counterparty::NAME => 'like',
        Counterparty::PHONE_NUMBER => 'like',
        Counterparty::LEGAL_ADDRESS => 'like',
        Counterparty::MAILING_ADDRESS => 'like'
    ];

    public function model(): string
    {
        return CounterpartyModel::class;
    }
}
