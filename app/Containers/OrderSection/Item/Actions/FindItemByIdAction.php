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

namespace App\Containers\OrderSection\Item\Actions;

use App\Containers\OrderSection\Item\Models\Item;
use App\Containers\OrderSection\Item\Tasks\FindItemByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class FindItemByIdAction extends Action
{
    /**
     * @param int $id
     * @return Item
     * @throws NotFoundException
     */
    public function run(int $id): Item
    {
        return app(FindItemByIdTask::class)->run($id);
    }
}
