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

namespace App\Containers\TelegramSection\Bot\Contracts;

interface DefaultStyleContract
{
    public function getHelloMessage(): string;
    public function getRememberPwdMessage(): string;
    public function getInvalidClientPhoneNumberMessage(): string;
    public function getResetPasswordUrlMessage(string $url): string;
}
