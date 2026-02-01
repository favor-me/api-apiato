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

namespace App\Containers\TelegramSection\Bot\Services;

use App\Containers\TelegramSection\Bot\Actions\ForgotPasswordAction;
use App\Containers\TelegramSection\Bot\Handlers\Actions\ReplyInvalidClientPhoneNumberAction;
use App\Containers\TelegramSection\Bot\Handlers\Actions\ReplyResetPasswordUrlAction;
use App\Ship\Validation\Rules\PhoneNumber;
use Illuminate\Support\Stringable;

class HandleChatMessageService extends HandlerService
{
    protected Stringable $message;

    public function run(): mixed
    {
        $hasVerify = false;
        foreach ($this->getVerificationMethods() as $textHandle) {
            if ($this->$textHandle()) {
                $hasVerify = true;
                break;
            }
        }

        return $hasVerify;
    }

    public function setMessage(?Stringable $text): self
    {
        $this->message = $text;
        return $this;
    }

    protected function checkMessageIsClientPhoneNumber(): bool
    {
        if ($this->waitingClientPhoneNumber()) {
            $isPhone = true;
            $rule = new PhoneNumber();

            $contact = $this->handler
                ->getMessage()
                ->contact();

            $userPhoneNumber = is_null($contact) ? $this->message : $contact->phoneNumber();

            $rule->validate('phone', $userPhoneNumber, function () use (&$isPhone) {
                $isPhone = false;
            });

            if (!$isPhone) {
                $this->handler->runAction(ReplyInvalidClientPhoneNumberAction::class);
            } else {
                $forgotPasswordUrl = app(ForgotPasswordAction::class)->run($userPhoneNumber);
                if (is_null($forgotPasswordUrl)) {
                    $this->handler->runAction(ReplyInvalidClientPhoneNumberAction::class);
                    exit();
                } else {
                    $this->handler
                        ->runAction(
                            ReplyResetPasswordUrlAction::class,
                            fn (ReplyResetPasswordUrlAction &$action) => $action->setUrl($forgotPasswordUrl)
                        );
                }
            }
        }

        return false;
    }

    protected function getVerificationMethods(): array
    {
        return array_filter(
            get_class_methods($this),
            fn ($method) => preg_match('/^checkMessage/', $method)
        );
    }

    protected function waitingClientPhoneNumber(): bool
    {
        return $this->handler->getStorage()->has($this->handler::STORE_START_REMEMBER_PWD);
    }
}
