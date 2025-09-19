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

use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\OrderSection\Order\Data\Factories\OrderFactory;
use App\Containers\OrderSection\Order\Foundation\Order as BaseOrder;
use App\Ship\Database\Casts\Money as MoneyCast;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Database\Eloquent\Concerns\HasUpdatedBy;
use App\Ship\Parents\Models\Model;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read int $oid Уникальный идентификатор.
 * @property-read null|string $payment_type Тип оплаты.
 * @property-read Money $total Итоговая сумма.
 * @property-read null|string $comment Комментарий.
 * @property-read null|int $client_id Уникальный идентификатор.
 * @property-read null|int $created_by Уникальный идентификатор.
 * @property-read null|int $updated_by Уникальный идентификатор.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаления.
 * @property-read Organization $organization Связанная модель организации.
 * @property-read OrganizationClient $client Связанная модель клиента.
 * @property-read null|User $creator Связанная модель пользователя который создал заказ.
 * @property-read null|User $updater Связанная модель пользователя который обновил заказ.
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

    protected $fillable = [
        BaseOrder::ORGANIZATION_ID,
        BaseOrder::OID,
        BaseOrder::PAYMENT_TYPE,
        BaseOrder::TOTAL,
        BaseOrder::COMMENT,
        BaseOrder::CLIENT_ID
    ];

    protected $casts = [
        BaseOrder::TOTAL => MoneyCast::class
    ];

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
}
