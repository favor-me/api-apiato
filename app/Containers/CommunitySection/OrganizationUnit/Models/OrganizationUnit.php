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

namespace App\Containers\CommunitySection\OrganizationUnit\Models;

use App\Containers\CommunitySection\OrganizationUnit\Data\Factories\OrganizationUnitFactory;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit as BaseOrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Services\SetPricePriorityModelAttributesService;
use App\Containers\CommunitySection\OrganizationUnitType\Casts\OrganizationUnitType;
use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\ServiceType;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\Vendor\Unit\Models\Unit as UnitModel;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\DeletedAtAttribute;
use App\Ship\Traits\Model\IsNumbered;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $name Имя.
 * @property-read string|Type $type Тип.
 * @property-read null|string $sku Артикул.
 * @property-read int $ordering Значение для сортировки.
 * @property-read JSON $params Дополнительные параметры.
 * @property-read Money $cost_price Себестоимость.
 * @property-read null|float $price_up Наценка в %.
 * @property-read Money $client_price Цена для клиента.
 * @property-read null|float $balance Остаток.
 * @property-read bool $is_infinity_balance Флаг бесконечного остатка.
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read int $system_unit_id Уникальный идентификатор.
 * @property-read Carbon $created_at Дата и время создания.
 * @property-read Carbon $updated_at Дата и время обновления.
 * @property-read null|Carbon $deleted_at Дата и время удаления.
 * @property-read UnitModel $systemUnit Связанная модель еденицы измерения.
 * @property-read Collection $modelNotes Колекция заметок для событий модели (История).
 *
 * @method static OrganizationUnitFactory factory(...$parameters)
 */
class OrganizationUnit extends Model
{
    use SoftDeletes;
    use IsNumbered;
    use CreatedAtAttribute;
    use UpdatedAtAttribute;
    use DeletedAtAttribute;

    public const string TABLE = 'organization_units';
    public const string RESOURCE_KEY = 'OrganizationUnit';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $with = [
        BaseOrganizationUnit::SYSTEM_UNIT
    ];

    protected $fillable = [
        PARAMS,
        BaseOrganizationUnit::NAME,
        BaseOrganizationUnit::TYPE,
        BaseOrganizationUnit::SKU,
        BaseOrganizationUnit::ORDERING,
        UnitPrice::COST_PRICE,
        UnitPrice::PRICE_UP,
        UnitPrice::CLIENT_PRICE,
        UnitPrice::BALANCE,
        UnitPrice::IS_INFINITY_BALANCE,
        BaseOrganizationUnit::ORGANIZATION_ID,
        BaseOrganizationUnit::SYSTEM_UNIT_ID
    ];

    protected $casts = [
        PARAMS => JsonCast::class,
        UnitPrice::PRICE_UP => 'float',
        UnitPrice::BALANCE => 'float',
        UnitPrice::COST_PRICE => MoneyCast::class,
        UnitPrice::CLIENT_PRICE => MoneyCast::class,
        UnitPrice::IS_INFINITY_BALANCE => 'boolean',
        BaseOrganizationUnit::TYPE => OrganizationUnitType::class
    ];

    public function setRawAttributes(array $attributes, $sync = false): self
    {
        $attributes = (new SetPricePriorityModelAttributesService($attributes))->run();
        return parent::setRawAttributes($attributes, $sync);
    }

    public function systemUnit(): BelongsTo
    {
        return $this->belongsTo(UnitModel::class, BaseOrganizationUnit::SYSTEM_UNIT_ID, ID);
    }

    public function modelNotes(int $limit = 10): HasMany
    {
        return $this
            ->hasMany(ModelNoteModel::class, ModelNote::MODEL_ID, ID)
            ->where(ModelNote::MODEL, self::class)
            ->orderByDesc(ID)
            ->orderByDesc(self::CREATED_AT)
            ->limit($limit);
    }

    protected function performInsert(Builder $query): bool
    {
        $this->setIsInfinityBalanceIfServiceType();
        return parent::performInsert($query);
    }

    private function setIsInfinityBalanceIfServiceType(): void
    {
        $serviceTypeName = Manager::getInstance()
            ->get(ServiceType::class)
            ->getName();

        if ($this->type->getName() === $serviceTypeName) {
            $this->setAttribute(UnitPrice::IS_INFINITY_BALANCE, true);
        }
    }
}
