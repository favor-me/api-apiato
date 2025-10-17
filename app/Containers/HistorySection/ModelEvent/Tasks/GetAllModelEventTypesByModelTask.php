<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelEvent\Tasks;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventManager;
use App\Containers\OrderSection\Order\Models\Order;
use Illuminate\Support\Collection;

class GetAllModelEventTypesByModelTask extends ModelEventTask
{
    protected array $map = [
        Order::class => '',
    ];

    public function run(?string $modelClass): Collection
    {
        $map = collect($this->map);
        $manager = ModelEventManager::getInstance();

        if (is_null($modelClass)) {
            return $manager->all();
        }

        return $manager->getAllByType($map->get($modelClass));
    }
}
