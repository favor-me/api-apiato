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

namespace App\Containers\CommunitySection\Counterparty\UI\API\Transformers;

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;

class AdminCounterpartyTransformer extends CounterpartyTransformer
{
    public function transform(CounterpartyModel $counterparty): array
    {
        return parent::transform($counterparty) +
            [
                $this->realKey(ID) => $counterparty->id,
                $this->realKey(Counterparty::ORGANIZATION_ID) => $counterparty->organization_id
            ];
    }
}
