<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Mails;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserForgotPasswordMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected User $recipient,
        protected string $token,
        protected string $resetUrl
    ) {
    }

    public function build(): self
    {
        return $this->view('appSection@user::user-forgot-password')
            ->to(
                $this->recipient->email,
                $this->recipient->name
            )
            ->subject(
                __('appSection@user::mail.tpl_forgot_password.subject')
            )
            ->with([
                'token' => $this->token,
                'resetUrl' => $this->resetUrl,
                'email' => $this->recipient->email,
            ]);
    }
}
