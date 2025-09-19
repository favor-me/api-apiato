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
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Data\Factories\ItemFactory;
use App\Containers\OrderSection\Item\Foundation\Item as BaseItem;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Parents\Collections\EloquentCollection;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $order_id Уникальный идентификатор.
 * @property-read int $unit_id Уникальный идентификатор.
 * @property-read string $name Имя.
 * @property-read string $sku Артикул.
 * @property-read Money $cost_price Себестоимость.
 * @property-read Money $client_price Цена продажи.
 * @property-read float $amount Количество.
 * @property-read Order $order Связанная модель заказа.
 * @property-read null|OrganizationUnit $unit Связанная модель юнита.
 *
 * @method static ItemFactory factory(...$parameters)
 */
class Item extends Model
{
    use IsNumbered;

    public $timestamps = false;
    public const TABLE = 'order_items';
    public const RESOURCE_KEY = 'Item';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseItem::ORDER_ID,
        BaseItem::UNIT_ID,
        BaseItem::NAME,
        BaseItem::SKU,
        BaseItem::COST_PRICE,
        BaseItem::CLIENT_PRICE,
        BaseItem::AMOUNT
    ];

    protected $casts = [
        BaseItem::COST_PRICE => MoneyCast::class,
        BaseItem::CLIENT_PRICE => MoneyCast::class
    ];

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
