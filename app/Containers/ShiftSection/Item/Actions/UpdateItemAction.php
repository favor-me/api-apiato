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

namespace App\Containers\ShiftSection\Item\Actions;

use App\Containers\ShiftSection\Item\Dto\UpdateItemDto;
use App\Containers\ShiftSection\Item\Models\Item;
use App\Containers\ShiftSection\Item\Tasks\UpdateItemTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateItemAction extends Action
{
    /**
     * @param UpdateItemDto $dto
     * @return Item
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateItemDto $dto): Item
    {
        return app(UpdateItemTask::class)->run($dto);
    }
}
