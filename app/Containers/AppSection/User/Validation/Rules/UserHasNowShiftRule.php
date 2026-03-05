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

namespace App\Containers\AppSection\User\Validation\Rules;

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserHasNowShiftRule extends ValidationRule
{
    protected ?UserModel $user = null;

    public function __construct(mixed $user)
    {
        $this->findAndSetUser($user);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->user)) {
            $fail(Container::trans('user.not_found'));
        }

        if (is_null($this->user->nowShift)) {
            $fail(Container::trans('user.not_found_now_shift'));
        } elseif ($this->user->nowShift->id !== (int)$value) {
            $fail(Container::trans('validation.has_now_shift.invalid_shift'));
        }
    }

    protected function findAndSetUser(mixed $user): void
    {
        if ($user instanceof UserModel) {
            $this->user = $user;
        } else {
            if ($user === 'auth') {
                $this->user = Auth::user();
            } elseif (!is_null($user)) {
                $this->user = app(FindUserByIdTask::class)->run($user);
            }
        }
    }
}
