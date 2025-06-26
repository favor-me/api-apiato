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

namespace App\Containers\AppSection\UserDevice\Foundation;

use App\Ship\Foundation\SectionContainer;

final class UserDevice extends SectionContainer
{
    public const MODEL = 'model';
    public const TOKEN = 'token';
    public const MODEL_MAX_LENGTH = 100;

    protected string $apiBaseUri = 'user/{user_id}/devices';
}
