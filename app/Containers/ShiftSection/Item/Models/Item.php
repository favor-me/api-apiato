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

namespace App\Containers\ShiftSection\Item\Models;

use App\Containers\AppSection\User\Models\User;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\ShiftSection\Item\Data\Factories\ItemFactory;
use App\Containers\ShiftSection\Item\Foundation\Item as BaseItem;
use App\Containers\ShiftSection\ItemType\Casts\ItemType;
use App\Containers\ShiftSection\ItemType\Type;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $shift_id Уникальный идентификатор смены.
 * @property-read int|null $order_id Уникальный идентификатор заказа.
 * @property-read Type $type Тип позиции.
 * @property-read Money $value Стоимость позиции.
 * @property-read string|null $description Описание.
 * @property-read JSON $system_note Системная заметка.
 * @property-read int|null $created_by Уникальный идентификатор кто создал.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Shift $shift Связанная модель смены.
 * @property-read Order|null $order Связанная модель заказа.
 * @property-read User|null $creator Связанная модель пользователя который созал.
 *
 * @method static ItemFactory factory(...$parameters)
 */
class Item extends Model
{
    use IsNumbered;
    use HasCreatedBy;

    public const string TABLE = 'shift_items';
    public const string RESOURCE_KEY = 'Item';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseItem::SHIFT_ID,
        BaseItem::ORDER_ID,
        BaseItem::TYPE,
        BaseItem::VALUE,
        BaseItem::DESCRIPTION,
        BaseItem::SYSTEM_NOTE,
        CREATED_BY
    ];

    protected $casts = [
        BaseItem::TYPE => ItemType::class,
        BaseItem::VALUE => MoneyCast::class,
        BaseItem::SYSTEM_NOTE => JsonCast::class
    ];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, BaseItem::SHIFT_ID, ID);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, BaseItem::ORDER_ID, ID);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, CREATED_BY, ID);
    }
}
