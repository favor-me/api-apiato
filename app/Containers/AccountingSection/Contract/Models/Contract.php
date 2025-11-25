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

namespace App\Containers\AccountingSection\Contract\Models;

use App\Containers\AccountingSection\Contract\Data\Factories\ContractFactory;
use App\Containers\AccountingSection\Contract\Foundation\Contract as BaseContract;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Database\Eloquent\Models\OrganizationModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $name Название договора.
 * @property-read mixed $number Порядковый номер.
 * @property-read int $counterparty_id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read mixed $start_at Дата начала.
 * @property-read mixed $finish_at Дата завершения.
 * @property-read bool $is_live_now Флаг действия договора в текущий момент. TODO write unit test
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаления.
 * @property-read Counterparty $organization Связанная модель организации.
 * @property-read Counterparty $counterparty Связанная модель контрагента.
 * @property-read Collection $unitPrices Список переопределенных цен для продуктов и услуг.
 *
 * @method static ContractFactory factory(...$parameters)
 */
class Contract extends OrganizationModel
{
    use SoftDeletes;

    public const string TABLE = 'contracts';
    public const string RESOURCE_KEY = 'Contract';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseContract::NAME,
        BaseContract::NUMBER,
        BaseContract::COUNTERPARTY_ID,
        BaseContract::ORGANIZATION_ID,
        BaseContract::START_AT,
        BaseContract::FINISH_AT
    ];

    protected $casts = [
        BaseContract::START_AT => 'datetime',
        BaseContract::FINISH_AT => 'datetime'
    ];

    public function isLiveNow(): Attribute
    {
        return Attribute::get(function () {
            $now = Carbon::now();
            return $now->gte($this->start_at) && $this->finish_at->gte($now->toDateString());
        });
    }

    public function unitPrices(): HasManyThrough
    {
        return $this
            ->hasManyThrough(
                OrganizationUnitModel::class,
                UnitPriceModel::class,
                UnitPrice::MODEL_ID,
                ID,
                ID,
                UnitPrice::UNIT_ID
            )
            ->where(UnitPriceModel::TABLE . '.' . UnitPrice::MODEL, Contract::class)
            ->select([
                OrganizationUnitModel::TABLE . '.' . ID,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::NAME,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::TYPE,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::SKU,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::ORDERING,
                OrganizationUnitModel::TABLE . '.' . PARAMS,
                UnitPriceModel::TABLE . '.' . UnitPrice::MODEL,
                UnitPriceModel::TABLE . '.' . UnitPrice::COST_PRICE,
                UnitPriceModel::TABLE . '.' . UnitPrice::PRICE_UP,
                UnitPriceModel::TABLE . '.' . UnitPrice::CLIENT_PRICE,
                OrganizationUnitModel::TABLE . '.' . UnitPrice::BALANCE,
                OrganizationUnitModel::TABLE . '.' . UnitPrice::IS_INFINITY_BALANCE,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::ORGANIZATION_ID,
                OrganizationUnitModel::TABLE . '.' . OrganizationUnit::SYSTEM_UNIT_ID,
                OrganizationUnitModel::TABLE . '.' . CREATED_AT,
                OrganizationUnitModel::TABLE . '.' . UPDATED_AT,
                OrganizationUnitModel::TABLE . '.' . DELETED_AT,
            ]);
    }

    public function counterparty(): BelongsTo
    {
        return $this->belongsTo(Counterparty::class, BaseContract::COUNTERPARTY_ID, ID);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, BaseContract::ORGANIZATION_ID, ID);
    }

    protected function performInsert(Builder $query): bool
    {
        $this->setOrganizationIdPerformInsert();
        $this->setNumberPerformInsert($query);

        return parent::performInsert($query);
    }

    protected function setOrganizationIdPerformInsert(): void
    {
        if (is_null($this->organization_id)) {
            $this->setAttribute(BaseContract::ORGANIZATION_ID, Auth::user()->organization_id);
        }
    }

    protected function setNumberPerformInsert(Builder $query): void
    {
        $lastNumber = $query
            ->newModelInstance()
            ->max(BaseContract::NUMBER);

        $this->setAttribute(BaseContract::NUMBER, (int)$lastNumber + 1);
    }
}
