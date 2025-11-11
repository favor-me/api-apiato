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

namespace App\Containers\CommunitySection\Counterparty\Actions;

use App\Containers\CommunitySection\Counterparty\Dto\UpdateCounterpartyDto;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Counterparty\Tasks\UpdateCounterpartyTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateCounterpartyAction extends Action
{
    /**
     * @param UpdateCounterpartyDto $dto
     * @return Counterparty
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateCounterpartyDto $dto): Counterparty
    {
        return app(UpdateCounterpartyTask::class)->run($dto);
    }
}
