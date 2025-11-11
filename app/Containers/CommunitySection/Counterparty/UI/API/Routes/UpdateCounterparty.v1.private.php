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
 * @apiName updateCommunityCounterparty

 * @api {post} /v1/community/counterparties/:id Изменить
 * @apiDescription Изменить.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiParam {String} id Уникальный идентификатор
 *
 * @apiBody {String} [name]
 * @apiBody {String} [address]
 * @apiBody {String} [phone_number]
 * @apiBody {String} [email]
 * @apiBody {String} [country]
 * @apiBody {String} [bank_data]
 * @apiBody {String} [organization_id]
 *
 * @apiUse CounterpartySuccessSingleResponse
 */

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\UI\API\Controllers\UpdateCounterpartyController;
use Illuminate\Support\Facades\Route;

Route::patch(Container::getApiUri('{' . ID . '}'), UpdateCounterpartyController::class)
    ->name('api_community_counterparty_update_counterparty')
    ->middleware(['auth:api']);
