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

use App\Containers\OrderSection\Order\Tasks\DeleteOrdersTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class DeleteOrdersAction extends Action
{
    /**
     * @param array $ids
     * @return int|null
     * @throws NotFoundException
     */
    public function run(array $ids): ?int
    {
        return app(DeleteOrdersTask::class)->run($ids);
    }
}
