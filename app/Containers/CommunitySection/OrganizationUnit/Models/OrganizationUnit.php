<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Models;

use App\Containers\CommunitySection\OrganizationUnit\Data\Factories\OrganizationUnitFactory;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit as BaseOrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Containers\Vendor\Unit\Models\Unit;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property-read Unit $systemUnit Связанная модель еденицы измерения.
 *
 * @method static OrganizationUnitFactory factory(...$parameters)
 */
class OrganizationUnit extends Model
{
    use SoftDeletes;
    use IsNumbered;

    public const TABLE = 'organization_units';
    public const RESOURCE_KEY = 'OrganizationUnit';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $with = [
        BaseOrganizationUnit::INCLUDE_SYSTEM_UNIT
    ];

    protected $fillable = [
        PARAMS,
        BaseOrganizationUnit::NAME,
        BaseOrganizationUnit::TYPE,
        BaseOrganizationUnit::SKU,
        BaseOrganizationUnit::ORDERING,
        BaseOrganizationUnit::COST_PRICE,
        BaseOrganizationUnit::PRICE_UP,
        BaseOrganizationUnit::CLIENT_PRICE,
        BaseOrganizationUnit::BALANCE,
        BaseOrganizationUnit::IS_INFINITY_BALANCE,
        BaseOrganizationUnit::ORGANIZATION_ID,
        BaseOrganizationUnit::SYSTEM_UNIT_ID
    ];

    protected $casts = [
        PARAMS => JsonCast::class,
        BaseOrganizationUnit::PRICE_UP => 'float',
        BaseOrganizationUnit::BALANCE => 'float',
        BaseOrganizationUnit::COST_PRICE => MoneyCast::class,
        BaseOrganizationUnit::CLIENT_PRICE => MoneyCast::class,
        BaseOrganizationUnit::IS_INFINITY_BALANCE => 'boolean'
    ];

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn(string $type) => Manager::getInstance()->get($type)
        );
    }

    public function systemUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, BaseOrganizationUnit::SYSTEM_UNIT_ID, ID);
    }
}
