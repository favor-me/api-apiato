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

namespace App\Containers\OrderSection\Order\Models;

use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Data\Factories\OrderFactory;
use App\Containers\OrderSection\Order\Foundation\Order as BaseOrder;
use App\Containers\OrderSection\PaymentType\Casts\PaymentType as PaymentTypeCast;
use App\Containers\OrderSection\PaymentType\Type as PaymentType;
use App\Containers\OrderSection\Status\Models\Status;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Database\Eloquent\Concerns\HasUpdatedBy;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read int $oid Уникальный идентификатор.
 * @property-read null|PaymentType $payment_type Тип оплаты.
 * @property-read Money $total Итоговая сумма.
 * @property-read Money $profit Прибыль.
 * @property-read null|string $comment Комментарий.
 * @property-read null|int $client_id Уникальный идентификатор клиента.
 * @property-read null|int $counterparty_id Уникальный идентификатор контрагента.
 * @property-read null|int $contract_id Уникальный идентификатор контракта.
 * @property-read null|int $created_by Уникальный идентификатор пользователя который создал.
 * @property-read null|int $updated_by Уникальный идентификатор пользователя который обновил.
 * @property-read null|int $status_id Уникальный идентификатор статуса.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $completed_at Дата и время завершения.
 * @property-read Carbon|null $canceled_at Дата и время отмены.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаления.
 * @property-read Organization $organization Связанная модель организации.
 * @property-read OrganizationClient $client Связанная модель клиента.
 * @property-read null|Contract $contract Связанная модель договора.
 * @property-read null|Counterparty $counterparty Связанная модель контракта.
 * @property-read null|User $creator Связанная модель пользователя который создал заказ.
 * @property-read null|User $updater Связанная модель пользователя который обновил заказ.
 * @property-read null|Status $status Связанная модель статуса.
 * @property-read ItemEloquentCollection $items Коллекция позиций заказа.
 *
 * @method static OrderFactory factory(...$parameters)
 */
class Order extends Model
{
    use HasCreatedBy;
    use HasUpdatedBy;
    use SoftDeletes;
    use IsNumbered;

    public const TABLE = 'orders';
    public const RESOURCE_KEY = 'Order';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $with = [
        BaseOrder::ITEMS
    ];

    protected $fillable = [
        BaseOrder::ORGANIZATION_ID,
        BaseOrder::OID,
        BaseOrder::PAYMENT_TYPE,
        BaseOrder::TOTAL,
        BaseOrder::PROFIT,
        BaseOrder::COMMENT,
        BaseOrder::CLIENT_ID,
        BaseOrder::COUNTERPARTY_ID,
        BaseOrder::CONTRACT_ID,
        BaseOrder::STATUS_ID,
        BaseOrder::COMPLETED_AT,
        BaseOrder::CANCELED_AT
    ];

    protected $casts = [
        BaseOrder::TOTAL => MoneyCast::class,
        BaseOrder::PROFIT => MoneyCast::class,
        BaseOrder::PAYMENT_TYPE => PaymentTypeCast::class,
        BaseOrder::COMPLETED_AT => 'datetime',
        BaseOrder::CANCELED_AT => 'datetime'
    ];

    public function calculateTotal(bool $write = false): self
    {
        $total = app('money');
        $profit = app('money');

        $this
            ->items()
            ->get()
            ->each(function (ItemModel $item) use (&$total, &$profit) {
                $total->add($item->getTotalClientPrice());
                $profit->add($item->getProfit());
            });

        $this->setAttribute(BaseOrder::TOTAL, $total);
        $this->setAttribute(BaseOrder::PROFIT, $profit);

        if ($write) {
            $this->update();
            $this->refresh();
        }

        return $this;
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemModel::class, Item::ORDER_ID, ID);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, BaseOrder::ORGANIZATION_ID, ID);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(OrganizationClient::class, BaseOrder::CLIENT_ID, ID);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, CREATED_BY, ID);
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, UPDATED_BY, ID);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, BaseOrder::STATUS_ID, ID);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, BaseOrder::CONTRACT_ID, ID);
    }

    public function counterparty(): BelongsTo
    {
        return $this->belongsTo(Counterparty::class, BaseOrder::COUNTERPARTY_ID, ID);
    }

    public function setCompletedAt(): self
    {
        $this->setAttribute(BaseOrder::COMPLETED_AT, $this->freshTimestamp());
        return $this;
    }

    public function setCanceledAt(): self
    {
        $this->setAttribute(BaseOrder::CANCELED_AT, $this->freshTimestamp());
        return $this;
    }
}
