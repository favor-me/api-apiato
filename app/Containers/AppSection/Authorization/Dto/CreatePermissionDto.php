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

namespace App\Containers\AppSection\Authorization\Dto;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Dto\Dto;

class CreatePermissionDto extends Dto
{
    public ?string $section = null;
    public ?string $container = null;
    public string $name;
    public string $guard_name = Permission::GUARD_NAME_API;
    public ?string $display_name = null;
    public ?string $description = null;
}
