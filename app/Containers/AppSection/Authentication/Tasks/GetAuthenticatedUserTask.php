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

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class GetAuthenticatedUserTask
 *
 * @package App\Containers\AppSection\Authentication\Tasks
 */
class GetAuthenticatedUserTask extends Task
{
    /**
     * Run action.
     *
     * @return Authenticatable|null
     */
    public function run(): ?Authenticatable
    {
        return Auth::user();
    }
}
