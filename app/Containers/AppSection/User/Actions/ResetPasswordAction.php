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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Dto\ResetUserPasswordDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordAction extends Action
{
    /**
     * @param ResetUserPasswordDto $dto
     * @return string
     * @throws InternalErrorException
     */
    public function run(ResetUserPasswordDto $dto): string
    {
        try {
            return app('fm.auth.password.broker')
                ->reset(
                    $dto->toCredentials(),
                    function (UserModel $user, string $password) {
                        $user
                            ->forceFill([
                                User::PASSWORD => Hash::make($password),
                                User::REMEMBER_TOKEN => Str::random(60),
                            ])
                            ->save();
                    }
                );
        } catch (Exception $e) {
            throw new InternalErrorException($e->getMessage(), (int)$e->getCode());
        }
    }
}
