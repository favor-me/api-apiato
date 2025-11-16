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
 * @apiName getAllAccountingContract

 * @api {get} /v1/accounting/contracts Список
 * @apiDescription Получить список.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner|organization_worker`
 *
 * @apiParam {String="1,0"} [only-trashed] Вкл.\Откл.показ корзины.
 * @apiParam {String="live-now"} [only] `live-now` - Получить только актуальные на сегодня.
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
 */

use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\UI\API\Controllers\GetAllContractsController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllContractsController::class)
    ->name('api_accounting_contract_get_all_contract')
    ->middleware(['auth:api']);
