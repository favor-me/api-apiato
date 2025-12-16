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
 * @apiName getAllCommunityCounterpartyBankSchema
 *
 * @api {get} /v1/community/counterparties/:country/:ownership_type/bank-data-schema Схема реквизитов
 * @apiDescription Получить схему банковских реквизитов страны.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с правами `organization_owner`
 *
 * @apiParam {String=rus} country Код страны.
 * @apiParam {String=ip,ooo,self_employed} ownership_type Тип собственности.
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
{
    "data": {
        "inn": {
            "type": "int",
            "name": "inn",
            "title": "ИНН",
            "value": null
        },
        "kpp": {
            "type": "int",
            "name": "kpp",
            "title": "КПП",
            "value": null
        },
        "orgnip": {
            "type": "int",
            "name": "orgnip",
            "title": "ОРГНИП",
            "value": null
        },
        "payment_account": {
            "type": "int",
            "name": "payment_account",
            "title": "Расчётный счёт",
            "value": null
        },
        "bank": {
            "type": "string",
            "name": "bank",
            "title": "Название банка",
            "value": null
        },
        "correspondent_account": {
            "type": "int",
            "name": "correspondent_account",
            "title": "Кор. счёт",
            "value": null
        },
        "bik": {
            "type": "int",
            "name": "bik",
            "title": "БИК",
            "value": null
        },
        "okpo": {
            "type": "int",
            "name": "okpo",
            "title": "ОКПО",
            "value": null
        },
        "okved": {
            "type": "string",
            "name": "okved",
            "title": "ОКВЭД",
            "value": null
        },
        "okato": {
            "type": "int",
            "name": "okato",
            "title": "ОКАТО",
            "value": null
        }
    }
}
 */

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\UI\API\Controllers\GetCounterpartyBankDataSchemaController;
use Illuminate\Support\Facades\Route;

$uri = Container::getApiUri('{' . Counterparty::COUNTRY . '}/{' . Counterparty::OWNERSHIP_TYPE . '}/bank-data-schema');

Route::get($uri, GetCounterpartyBankDataSchemaController::class)
    ->name('api_community_counterparty_get_counterparty_country_bank_data_schema')
    ->middleware(['auth:api']);
