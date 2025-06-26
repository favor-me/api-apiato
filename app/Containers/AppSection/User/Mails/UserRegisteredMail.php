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

class UserRegisteredMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $user)
    {
    }

    public function build(): self
    {
        return $this->view('appSection@user::user-registered')
            ->subject(
                __('appSection@user::mail.tpl_registered.subject')
            )
            ->to(
                $this->user->email,
                $this->user->name
            )
            ->with([
                'name' => $this->user->name
            ]);
    }
}
