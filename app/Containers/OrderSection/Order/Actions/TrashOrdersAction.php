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

namespace App\Containers\OrderSection\Order\Actions;

use App\Containers\OrderSection\Order\Events\TrashedOrdersEvent;
use App\Containers\OrderSection\Order\Tasks\TrashOrdersTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Actions\Action;

class TrashOrdersAction extends Action
{
    /**
     * @param array $ids
     * @return int
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): int
    {
        $result = app(TrashOrdersTask::class)->run($ids);
        event(new TrashedOrdersEvent($ids));
        return $result;
    }
}
