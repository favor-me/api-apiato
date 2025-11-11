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

namespace App\Containers\CommunitySection\Counterparty\Tasks;

use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Ship\Traits\Task\FindByIdRun;

/**
 * @method Counterparty run(int $id)
 */
class FindCounterpartyByIdTask extends CounterpartyTask
{
    use FindByIdRun;
}
