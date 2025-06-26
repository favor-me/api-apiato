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

namespace App\Containers\AppSection\User\Models;

use Apiato\Core\Contracts\HasResourceKey;
use App\Containers\AppSection\Authentication\Traits\AuthenticationTrait;
use App\Containers\AppSection\Authorization\Traits\AuthorizationTrait;
use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Database\Casts\JSON;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JBZoo\Data\JSON as JsonData;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $login Уникальный логин.
 * @property-read string $name Имя.
 * @property-read string $patronymic
 * @property-read string $surname
 * @property-read bool $gender Пол.
 * @property-read Carbon|null $birth Дата дня рождения
 * @property-read string $avatar
 * @property-read string $email
 * @property-read int $phone_number
 * @property-read null|string $telegram_user_name
 * @property-read Carbon $email_verified_at
 * @property-read Carbon $phone_number_verified_at
 * @property-read bool $is_admin
 * @property-read bool $is_organization_owner
 * @property-read string $remember_token
 * @property-read string $password
 * @property-read JsonData $params Дополнительные параметры.
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deleted_at
 * @property-read Collection $roles
 * @property-read Collection $contacts
 * @property-read Collection $devices Список устройств.
 * @property-read Collection $actualDevices Список актуалных устройств.
 * @property-read Collection $telegramBots Список телеграм ботов.
 *
 * @method static UserFactory factory(...$parameters)
 * @method static User findOrFail($id, $columns = ['*'])
 * @method static int count()
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class User extends UserModel implements HasResourceKey
{
    use Notifiable;
    use SoftDeletes;
    use AuthorizationTrait;
    use AuthenticationTrait;

    public const TABLE = 'users';
    public const WEEK_LAST_ACTIVE_DEVICES = 2;

    protected $table = self::TABLE;

    protected $fillable = [
        BaseUser::NAME,
        BaseUser::LOGIN,
        BaseUser::BIRTH,
        BaseUser::EMAIL,
        BaseUser::AVATAR,
        BaseUser::GENDER,
        BaseUser::SURNAME,
        BaseUser::PASSWORD,
        BaseUser::IS_ADMIN,
        BaseUser::IS_ORGANIZATION_OWNER,
        BaseUser::ORGANIZATION_ID,
        BaseUser::PATRONYMIC,
        BaseUser::PHONE_NUMBER,
        PARAMS
    ];

    protected $hidden = [
        BaseUser::PASSWORD,
        BaseUser::REMEMBER_TOKEN
    ];

    protected $casts = [
        PARAMS => JSON::class,
        BaseUser::BIRTH => 'date',
        BaseUser::GENDER => 'boolean',
        BaseUser::PHONE_NUMBER => 'int',
        BaseUser::IS_ADMIN => 'boolean',
        BaseUser::IS_ORGANIZATION_OWNER => 'boolean',
        BaseUser::EMAIL_VERIFIED_AT => 'datetime',
        BaseUser::PHONE_NUMBER_VERIFIED_AT => 'datetime'
    ];

    public function getDefaultLogin(): string
    {
        return 'profile-' . $this->id;
    }

    public function getFullName(): string
    {
        return implode(' ', [
            Str::ucfirst($this->surname),
            Str::ucfirst($this->name),
            Str::ucfirst($this->patronymic)
        ]);
    }

    public function routeNotificationForFcm(): array
    {
        return $this->actualDevices
            ->pluck(BaseUserDevice::TOKEN)
            ->toArray();
    }

    public function devices(): HasMany
    {
        return $this->hasMany(UserDevice::class, BaseUser::ID, ID);
    }

    public function actualDevices(): HasMany
    {
        $fromDate = Carbon::now()->subWeeks(self::WEEK_LAST_ACTIVE_DEVICES);

        return $this
            ->hasMany(UserDevice::class, BaseUser::ID, ID)
            ->whereDate(UPDATED_AT, '>=', $fromDate);
    }
}
