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

namespace App\Containers\TelegramSection\Bot\UI\API\Controllers;

use App\Containers\TelegramSection\Bot\Actions\RegisterBotCommandsAction;
use App\Containers\TelegramSection\Bot\UI\API\Requests\RegisterBotCommandsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RegisterBotCommandsController extends ApiController
{
    /**
     * @param RegisterBotCommandsRequest $request
     * @param RegisterBotCommandsAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RegisterBotCommandsRequest $request,
        RegisterBotCommandsAction $action
    ): JsonResponse {
        return new JsonResponse([], $action->run()->status());
    }
}
