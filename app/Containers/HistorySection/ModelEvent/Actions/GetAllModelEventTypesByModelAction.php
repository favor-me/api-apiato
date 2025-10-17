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

namespace App\Containers\HistorySection\ModelEvent\Actions;

use App\Containers\HistorySection\ModelEvent\Tasks\GetAllModelEventTypesByModelTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllModelEventTypesByModelAction extends Action
{
    public function run(?string $modelClass): Collection
    {
        return app(GetAllModelEventTypesByModelTask::class)->run($modelClass);
    }
}
