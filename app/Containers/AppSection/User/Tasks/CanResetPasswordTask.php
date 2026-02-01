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

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Models\User as UserModel;
use Exception;

class CanResetPasswordTask extends UserTask
{
    public function run(string $token, string $columnValue): bool
    {
        $user = $this->findUserByPhoneNumber($columnValue);

        if (is_null($user)) {
            return false;
        }

        return app('fm.auth.password.broker')
            ->getTokens()
            ->exists($user, $token);
    }

    protected function findUserByPhoneNumber(string $phoneNumber): ?UserModel
    {
        try {
            return app(FindUserByPhoneNumberTask::class)->run($phoneNumber);
        } catch (Exception) {
            return null;
        }
    }
}
