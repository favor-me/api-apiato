<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.rubr/censes/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 *
 * @apiGroup ModelNotes
 * @apiName getAllModelNotes
 *
 * @api {get} /v1/model-notes Список
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiSuccessExample {json} Успешный ответ:
 * HTTP/1.1 200 OK
 */

use App\Containers\HistorySection\ModelNote\Facades\Container;
use App\Containers\HistorySection\ModelNote\UI\API\Controllers\GetAllModelNotesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri(), GetAllModelNotesController::class)
    ->name('api_model_note_get_all_model_notes')
    ->middleware(['auth:api']);
