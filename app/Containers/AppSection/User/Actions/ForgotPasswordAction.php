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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Dto\ForgotUserPasswordDto;
use App\Containers\AppSection\User\Mails\UserForgotPasswordMail;
use App\Containers\AppSection\User\Tasks\CreatePasswordResetTask;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAction extends Action
{
    /**
     * @param ForgotUserPasswordDto $dto
     * @throws InternalErrorException
     * @throws NotFoundException
     */
    public function run(ForgotUserPasswordDto $dto): void
    {
        $user = app(FindUserByEmailTask::class)->run($dto->email);

        //  Generate token.
        $token = app(CreatePasswordResetTask::class)->run($user);

        //  Get last segment of the URL.
        $resetUrl    = $dto->resetUrl;
        $url         = explode('/', $resetUrl);
        $lastSegment = $url[count($url) - 1];

        //  Validate the allowed endpoint is being used.
        if (!in_array($lastSegment, config('appSection-user.allowed-reset-password-urls'), true)) {
            throw new NotFoundException(__('appSection@user::user.url_not_allowed', [
                'url' => $resetUrl
            ]));
        }

        //  Send email.
        Mail::send(new UserForgotPasswordMail($user, $token, $resetUrl));
    }
}
