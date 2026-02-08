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
 * @apiGroup Telegram
 * @apiName registerTelegramBotCommands
 * @api {post} /v1/telegram/bot/register-menu Создание меню бота
 * @apiDescription Регистрирует меню бота с доступными командами.
 *
 * @apiVersion 1.0.0
 * @apiPermission Только администратор
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\TelegramSection\Bot\Facades\Container;
use App\Containers\TelegramSection\Bot\UI\API\Controllers\RegisterBotCommandsController;
use Illuminate\Support\Facades\Route;

Route::post(Container::getApiUri('register-menu'), RegisterBotCommandsController::class)
    ->name('api_telegram_register_bot_command');
