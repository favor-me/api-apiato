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

namespace App\Ship\Events\Handlers;

use App\Ship\Parents\Events\Event as EventHandler;
use Illuminate\Database\Eloquent\Model;

class ModelCreatingEventHandler extends EventHandler
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(string $event, array $models): void
    {
        collect($models)
            ->each(function (Model $model) {
                if (method_exists($model, 'updateCreatedBy')) {
                    $model->updateCreatedBy();
                }
                if (method_exists($model, 'updateUpdatedBy')) {
                    $model->updateUpdatedBy();
                }
            });
    }
}
