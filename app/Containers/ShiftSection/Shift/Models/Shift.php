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

namespace App\Containers\ShiftSection\Shift\Models;

use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Shift\Data\Factories\ShiftFactory;
use App\Containers\ShiftSection\Shift\Foundation\Shift as BaseShift;
use App\Containers\ShiftSection\Shift\Statuses\Manager;
use App\Containers\ShiftSection\Shift\Statuses\Status;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\FinishAtAttribute;
use App\Ship\Traits\Model\IsNumbered;
use App\Ship\Traits\Model\StartAtAttribute;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор организации.
 * @property-read int $organization_branch_id Уникальный идентификатор отделения организации.
 * @property-read Money $money Заработанные средства смены.
 * @property-read Carbon $start_at Дата и время начала смены.
 * @property-read Carbon $finish_at Дата и время завершения смены.
 * @property-read int $created_by Уникальный идентификатор пользователя чья смена.
 * @property-read int|null $confirmed_by Уникальный идентификатор пользователя кто подтвердил.
 * @property-read Status $status Текущий статус смены.
 * @property-read Carbon|null $confirmed_at Дата и время подтверждения.
 * @property-read Carbon|null $payment_at Дата и время оплаты.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 *
 * @property-read Collection $items Коллекция моделей позиций смены.
 * @property-read User $creator Связанная модель пользователя чья смена.
 * @property-read Organization $organization Связанная модель организации.
 * @property-read OrganizationBranch|null $organizationBranch Связанная модель отделения организации.
 *
 * @method static ShiftFactory factory(...$parameters)
 */
class Shift extends Model
{
    use IsNumbered;
    use HasCreatedBy;
    use StartAtAttribute;
    use FinishAtAttribute;
    use UpdatedAtAttribute;
    use CreatedAtAttribute;

    public const string TABLE = 'shifts';
    public const string RESOURCE_KEY = 'Shift';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseShift::ORGANIZATION_ID,
        BaseShift::ORGANIZATION_BRANCH_ID,
        BaseShift::START_AT,
        BaseShift::FINISH_AT,
        BaseShift::MONEY,
        BaseShift::CONFIRMED_BY,
        BaseShift::CONFIRMED_AT,
        BaseShift::PAYMENT_AT,
        CREATED_BY
    ];

    protected $casts = [
        BaseShift::START_AT => 'datetime',
        BaseShift::FINISH_AT => 'datetime',
        BaseShift::CONFIRMED_AT => 'datetime',
        BaseShift::PAYMENT_AT => 'datetime',
        BaseShift::MONEY => MoneyCast::class
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, CREATED_BY, ID);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, BaseShift::ORGANIZATION_ID, ID);
    }

    public function organizationBranch(): BelongsTo
    {
        return $this->belongsTo(OrganizationBranch::class, BaseShift::ORGANIZATION_BRANCH_ID, ID);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemModel::class, Item::SHIFT_ID, ID);
    }

    public function status(): Attribute
    {
        return Attribute::get(fn () => Manager::getInstance()->getShiftStatus($this));
    }
}
