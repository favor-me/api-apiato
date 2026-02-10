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

namespace App\Containers\OrderSection\Item\Models;

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnitType\Casts\OrganizationUnitType;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Data\Factories\ItemFactory;
use App\Containers\OrderSection\Item\Foundation\Item as BaseItem;
use App\Containers\OrderSection\Item\Services\ProfitService;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Parents\Collections\EloquentCollection;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $order_id Уникальный идентификатор заказа.
 * @property-read int $unit_id Уникальный идентификатор юнита организации (товар, услуга).
 * @property-read string|Type $type Тип.
 * @property-read string $name Имя.
 * @property-read string $sku Артикул.
 * @property-read Money $cost_price Себестоимость.
 * @property-read Money $client_price Цена продажи.
 * @property-read Money $unit_client_price Зафиксированная цена продажи товара или услуги.
 * @property-read float $amount Количество.
 * @property-read Order $order Связанная модель заказа.
 * @property-read null|OrganizationUnit $unit Связанная модель юнита.
 *
 * @method static ItemFactory factory(...$parameters)
 */
class Item extends Model
{
    use IsNumbered;

    public const string TABLE = 'order_items';
    public const string RESOURCE_KEY = 'Item';

    public $timestamps = false;
    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseItem::ORDER_ID,
        BaseItem::UNIT_ID,
        BaseItem::NAME,
        BaseItem::SKU,
        BaseItem::COST_PRICE,
        BaseItem::CLIENT_PRICE,
        BaseItem::UNIT_CLIENT_PRICE,
        BaseItem::AMOUNT,
        BaseItem::TYPE
    ];

    protected $casts = [
        BaseItem::COST_PRICE => MoneyCast::class,
        BaseItem::CLIENT_PRICE => MoneyCast::class,
        BaseItem::UNIT_CLIENT_PRICE => MoneyCast::class,
        BaseItem::TYPE => OrganizationUnitType::class
    ];

    public function isManualClientPrice(): bool
    {
        return !$this->client_price->compare($this->unit_client_price);
    }

    public function getProfit(): Money
    {
        return (new ProfitService())
            ->fromItem($this)
            ->calculate();
    }

    public function getTotalClientPrice(): Money
    {
        if ($this->amount > ZERO) {
            return $this->client_price->multiply($this->amount, true);
        }

        return $this->client_price;
    }

    public function newCollection(array $models = []): EloquentCollection
    {
        return new ItemEloquentCollection($models);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, BaseItem::ORDER_ID, ID);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnit::class, BaseItem::UNIT_ID, ID);
    }
}
