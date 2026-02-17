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

namespace App\Containers\AppSection\UserDevice\Models;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Data\Factories\UserDeviceFactory;
use App\Ship\Parents\Models\Model;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevices;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $user_id Уникальный идентификатор пользователя.
 * @property-read string $model Модель устройства.
 * @property-read string $token Токен устройства.
 * @property-read Carbon $created_at Дата и время создания.
 * @property-read Carbon $updated_at Дата и время обновления.
 * @property-read User $user Объект пользователя.
 *
 * @method static UserDeviceFactory factory(...$parameters)
 */
final class UserDevice extends Model
{
    use CreatedAtAttribute;
    use UpdatedAtAttribute;

    public const string TABLE = 'user_devices';
    public const string RESOURCE_KEY = 'UserDevice';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseUser::ID,
        BaseUserDevices::MODEL,
        BaseUserDevices::TOKEN
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, BaseUser::ID, ID);
    }
}
