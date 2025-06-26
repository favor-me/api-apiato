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

namespace App\Containers\AppSection\Authentication\Actions;

use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

class WebLogoutAction extends Action
{
    public function run(): void
    {
        Auth::logout();
        $this->removeApiTokens();
    }

    protected function removeApiTokens(): void
    {
        session()->remove(API_TOKEN_KEY);
        session()->remove(API_REFRESH_TOKEN_KEY);
    }
}
