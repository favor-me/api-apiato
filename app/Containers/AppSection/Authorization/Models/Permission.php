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

use Apiato\Core\Contracts\HasResourceKey;
use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\FactoryLocatorTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Apiato\Core\Traits\ModelTrait;
use App\Containers\AppSection\Authorization\Data\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @property int $id Унакальный идентификатор в системе.
 * @property string|null $section Название секции.
 * @property string|null $container Название контейнера в секции.
 * @property string $name Системное название разрешения.
 * @property string $guard_name Название раздела\контекста прав.
 * @property string $display_name Название разрешения для отображения.
 * @property string $description Подробное описание разрешения.
 * @property null|Carbon $created_at Дата и время создания.
 * @property null|Carbon $updated_at Дата и время обновления.
 *
 * @method static PermissionFactory factory($count = null, $state = [])
 */
class Permission extends SpatiePermission implements HasResourceKey
{
    use ModelTrait;
    use HashIdTrait;
    use HasResourceKeyTrait;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    public const GUARD_NAME_API = 'api';

    protected $guard_name = self::GUARD_NAME_API;

    protected $fillable = [
        'section',
        'container',
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    protected function getDisplayNameAttribute(?string $value): ?string
    {
        return $this->checkAndGetTranslationOrText($value);
    }

    protected function getDescriptionAttribute(?string $value): ?string
    {
        return $this->checkAndGetTranslationOrText($value);
    }

    protected function checkAndGetTranslationOrText(?string $value): ?string
    {
        return trans()->has($value) ? __($value) : $value;
    }
}
