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

namespace App\Containers\TelegramSection\Bot\UI\API\Requests;

use App\Ship\Requests\ApiRequest;

class RegisterBotCommandsRequest extends ApiRequest
{
    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isSergeyKalistratov'
        ]);
    }

    protected function isSergeyKalistratov(): bool
    {
        $user = $this->user();

        if (is_null($user)) {
            return false;
        }

        return $user->phone_number === 79272236975;
    }
}
