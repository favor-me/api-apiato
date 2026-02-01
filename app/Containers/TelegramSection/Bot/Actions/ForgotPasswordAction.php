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

namespace App\Containers\TelegramSection\Bot\Actions;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tasks\CreatePasswordResetTask;
use App\Containers\AppSection\User\Tasks\FindUserByPhoneNumberTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Utils\Str;
use Exception;
use Illuminate\Support\Arr;

class ForgotPasswordAction extends Action
{
    /**
     * @param string|int $phoneNumber
     * @return string
     * @throws InternalErrorException
     */
    public function run(string|int $phoneNumber): string
    {
        $phoneNumber = Str::toPhoneNumber($phoneNumber);

        $user = $this->findUser($phoneNumber);

        if (is_null($user)) {
            return false;
        }

        $token = app(CreatePasswordResetTask::class)->run($user);

        $resetUrlQuery = Arr::query([
            'token' => $token,
            $user->getColumnNameForPasswordReset() => $user->getColumnValueForPasswordReset()
        ]);

        return config('app.web_url') . '/password-reset' . '?' . $resetUrlQuery;
    }

    protected function findUser(int $phoneNumber): ?UserModel
    {
        try {
            return app(FindUserByPhoneNumberTask::class)->run($phoneNumber);
        } catch (Exception) {
            return null;
        }
    }
}
