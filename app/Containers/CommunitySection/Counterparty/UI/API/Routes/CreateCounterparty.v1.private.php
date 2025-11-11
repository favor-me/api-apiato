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
 * @apiName createCommunityCounterparty
 * @api {post} /v1/community/counterparties Создать
 * @apiDescription Создание.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} name Имя.
 * @apiBody {String} legal_address Юридический адрес.
 * @apiBody {String} mailing_address Почтовый адрес.
 * @apiBody {String} phone_number Номер телефона.
 * @apiBody {String} [email] Адрес электронной почты.
 * @apiBody {String=rus} country Страна.
 * @apiBody {Array|Object} bank_data Реквизиты банка.
 *
 * @apiUse CounterpartySuccessSingleResponse
 *
 * @apiParamExample {json} Банковские реквизиты для России:
{
    "bank_data": {
        "inn": "1234567893",
        "kpp": "387654321",
        "orgnip": "123456783098765",
        "payment_account": "12345478909876543212",
        "correspondent_account": "72345478909876543212",
        "bank": "Серго БАНК",
        "bik": "123416434",
        "okpo": "16547364"
    }
}
 */

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\UI\API\Controllers\CreateCounterpartyController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri(), CreateCounterpartyController::class)
    ->name('api_community_counterparty_create_counterparty')
    ->middleware(['auth:api']);
