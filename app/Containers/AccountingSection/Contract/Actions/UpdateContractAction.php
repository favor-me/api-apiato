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

namespace App\Containers\AccountingSection\Contract\Actions;

use App\Containers\AccountingSection\Contract\Dto\UpdateContractDto;
use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AccountingSection\Contract\Tasks\UpdateContractTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateContractAction extends Action
{
    /**
     * @param UpdateContractDto $dto
     * @return Contract
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateContractDto $dto): Contract
    {
        return app(UpdateContractTask::class)->run($dto);
    }
}
