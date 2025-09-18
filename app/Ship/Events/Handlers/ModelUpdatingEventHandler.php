<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Ship\Events\Handlers;

use App\Ship\Parents\Events\Event as EventHandler;
use Illuminate\Database\Eloquent\Model;

class ModelUpdatingEventHandler extends EventHandler
{
    public function handle(string $event, array $models)
    {
        collect($models)
            ->each(function (Model $model) {
                if (method_exists($model, 'updateUpdatedBy')) {
                    $model->updateUpdatedBy();
                }
            });
    }
}
