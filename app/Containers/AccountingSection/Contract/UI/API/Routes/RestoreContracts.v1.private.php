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
 * @apiGroup AccountingContract
 * @apiName restoreAccountingContract

 * @api {post} /v1/restore/accounting/contracts Восстановить
 * @apiDescription Восстановление одной или несколько записей. Перемещение из корзины в "рабочую зону"..
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
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
    "message": "Успешно восстановлены 3 контракта."
}
 */

use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\UI\API\Controllers\RestoreContractsController;
use Illuminate\Support\Facades\Route;

Route::post('restore/' . Container::getApiUri(), RestoreContractsController::class)
    ->name('api_accounting_contract_restore_contract')
    ->middleware(['auth:api']);
