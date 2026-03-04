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
use App\Containers\AppSection\Authentication\Password\CanResetPassword;
use App\Containers\AppSection\Authentication\Traits\AuthenticationTrait;
use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\Authorization\Traits\AuthorizationTrait;
use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Casts\JSON;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\DeletedAtAttribute;
use App\Ship\Traits\Model\IsNumbered;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property-read null|int $organization_id Уникальный идентификатор организации.
 * @property-read null|int $organization_branch_id Уникальный идентификатор отделения организации.
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deleted_at
 * @property-read null|OrganizationModel $organization
 * @property-read null|OrganizationBranchModel $organizationBranch
 * @property-read Collection $roles
 * @property-read Collection $contacts
 * @property-read Collection $devices Список устройств.
 * @property-read Collection $actualDevices Список актуальных устройств.
 * @property-read ShiftModel|null $nowShift Модель текущей смены.
 * @property-read Collection $telegramBots Список телеграм ботов.
 *
 * @method static UserFactory factory(...$parameters)
 * @method static User findOrFail($id, $columns = ['*'])
 * @method static int count()
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class User extends UserModel implements HasResourceKey, CanResetPassword
{
    use Notifiable;
    use SoftDeletes;
    use IsNumbered;
    use AuthorizationTrait;
    use AuthenticationTrait;
    use CreatedAtAttribute;
    use UpdatedAtAttribute;
    use DeletedAtAttribute;

    public const string TABLE = 'users';
    public const int WEEK_LAST_ACTIVE_DEVICES = 2;

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
        BaseUser::ORGANIZATION_BRANCH_ID,
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(OrganizationModel::class, BaseUser::ORGANIZATION_ID, ID);
    }

    public function organizationBranch(): BelongsTo
    {
        return $this->belongsTo(OrganizationBranchModel::class, BaseUser::ORGANIZATION_BRANCH_ID, ID);
    }

    public function nowShift(): HasOne
    {
        $now = Carbon::now();
        return $this->hasOne(ShiftModel::class, CREATED_BY, ID)
            ->whereRaw(implode(' ', [
                '\'' . $now->toDateTimeString() . '\' >= cast(' . Shift::START_AT . ' as datetime)',
                'and',
                '\'' . $now->toDateTimeString() . '\' <= cast(' . Shift::FINISH_AT . ' as datetime)'
            ]));
    }

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
        $fromDate = Carbon::now(client_timezone())
            ->subWeeks(self::WEEK_LAST_ACTIVE_DEVICES);

        return $this
            ->hasMany(UserDevice::class, BaseUser::ID, ID)
            ->whereDate(UPDATED_AT, '>=', $fromDate);
    }

    public function hasOrganizationOwnerRole(): bool
    {
        return $this->hasRole(RoleModel::ORGANIZATION_OWNER);
    }

    public function isRealOrganizationOwner(?int $organizationId = null): bool
    {
        $organizationId = is_null($organizationId) ? $this->organization_id : $organizationId;

        if (!is_null($organizationId)) {
            $user = clone $this;
            $user->setAttribute(BaseUser::ORGANIZATION_ID, $organizationId);

            /** @var null|OrganizationModel $organization */
            $organization = $user->organization()->first();

            if (is_null($organization)) {
                return false;
            }

            return $this->hasOrganizationOwnerRole() &&
                $this->is_organization_owner &&
                $organization->user_owner_id === $this->id;
        }

        return false;
    }

    public function getColumnNameForPasswordReset(): string
    {
        return BaseUser::PHONE_NUMBER;
    }

    public function getColumnValueForPasswordReset(): string
    {
        return $this->phone_number;
    }
}
