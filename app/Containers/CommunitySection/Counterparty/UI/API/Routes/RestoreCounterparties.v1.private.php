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
 *
 * @apiGroup CommunityCounterparty
 * @apiName restoreCommunityCounterparty

 * @api {post} /v1/restore/community/counterparties Восстановить
 * @apiDescription Восстановление одной или несколько записей. Перемещение из корзины в "рабочую зону"..
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {Array} ids Id массив элементов
 *
 * @apiParamExample {json} Пример формирования ids:
"ids": [
    "NxOpZowo9GmjKqdR",
    "XbPW7awNkzl83LD6",
    "KJqn4Z26Owdlv6MB"
]
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 202 Accepted
{
    "message": "Успешно восстановлены 3 элемента."
}
 */

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\UI\API\Controllers\RestoreCounterpartiesController;
use Illuminate\Support\Facades\Route;

Route::post('restore/' . Container::getApiUri(), RestoreCounterpartiesController::class)
    ->name('api_community_counterparty_restore_counterparty')
    ->middleware(['auth:api']);
