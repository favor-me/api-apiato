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

namespace App\Containers\OrganizationSection\UnitPrice\Models;

use App\Containers\OrganizationSection\UnitPrice\Data\Factories\UnitPriceFactory;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice as BaseUnitPrice;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read mixed $model Namespace модели.
 * @property-read int $model_id Уникальный идентификатор.
 * @property-read int $unit_id Уникальный идентификатор.
 * @property-read Money $cost_price Себестоимость.
 * @property-read Money $price_up Наценка.
 * @property-read mixed $client_price Цена продажи.
 * @property-read float $balance Баланс.
 * @property-read bool $is_infinity_balance Флаг бесконечного баланса.
 *
 * @method static UnitPriceFactory factory(...$parameters)
 */
class UnitPrice extends Model
{
    use IsNumbered;

    public const string TABLE = 'organization_unit_prices';
    public const string RESOURCE_KEY = 'UnitPrice';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;
    public $timestamps = false;

    protected $fillable = [
        BaseUnitPrice::MODEL,
        BaseUnitPrice::MODEL_ID,
        BaseUnitPrice::UNIT_ID,
        BaseUnitPrice::COST_PRICE,
        BaseUnitPrice::PRICE_UP,
        BaseUnitPrice::CLIENT_PRICE,
        BaseUnitPrice::BALANCE,
        BaseUnitPrice::IS_INFINITY_BALANCE
    ];

    protected $casts = [
        BaseUnitPrice::COST_PRICE => MoneyCast::class,
        BaseUnitPrice::CLIENT_PRICE => MoneyCast::class,
        BaseUnitPrice::IS_INFINITY_BALANCE => 'boolean'
    ];
}
