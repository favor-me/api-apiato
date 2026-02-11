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
 * @apiName createAccountingContract
 * @api {post} /v1/accounting/contracts Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролью `organization_owner`
 *
 * @apiBody {String} name Название договора.
 * @apiBody {String} counterparty_id Уникальный идентификатор контрагента.
 * @apiBody {String} start_at Дата начала.
 * @apiBody {String|Null} [finish_at] Дата завершения. (Если установить null договор считается бессрочным).
 *
 * @apiUse ContractSuccessSingleResponse
 */

use App\Containers\AccountingSection\Contract\Facades\Container;
use App\Containers\AccountingSection\Contract\UI\API\Controllers\CreateContractController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateContractController::class)
    ->name('api_accounting_contract_create_contract')
    ->middleware(['auth:api']);
