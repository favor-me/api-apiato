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

namespace App\Containers\AppSection\Authorization\Models;

use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Apiato\Core\Traits\FactoryLocatorTrait;
use App\Containers\AppSection\Authorization\Data\Factories\RoleFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $guard_name
 * @property-read string $display_name
 * @property-read string $description
 * @property-read string $created_at
 * @property-read string $updated_at
 * @property-read int $level
 *
 * @method static RoleFactory factory(...$parameters)
 */
class Role extends SpatieRole
{
    use HashIdTrait;
    use HasResourceKeyTrait;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    public const ADMIN = 'admin';
    public const CLIENT = 'client';
    public const SPECIALIST = 'specialist';

    protected string $guard_name = 'api';

    protected $fillable = [
        'name',
        'level',
        'guard_name',
        'description',
        'display_name'
    ];

    public function getDisplayNameAttribute($value): mixed
    {
        return trans()->has($value) ? __($value) : $value;
    }

    public function getDescriptionAttribute($value): mixed
    {
        return trans()->has($value) ? __($value) : $value;
    }
}
