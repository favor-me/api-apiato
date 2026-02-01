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

namespace App\Containers\TelegramSection\Bot\Styles;

use App\Containers\TelegramSection\Bot\Facades\Container;

class DefaultStyle extends Style
{
    public function getHelloMessage(): string
    {
        return Container::trans('default.hello');
    }

    public function getRememberPwdMessage(): string
    {
        return Container::trans('default.remember_pwd');
    }

    public function getInvalidClientPhoneNumberMessage(): string
    {
        return Container::trans('default.invalid_client_phone_number');
    }

    public function getResetPasswordUrlMessage(string $url): string
    {
        return Container::trans('default.reset_password_url', [
            'url' => $url
        ]);
    }
}
