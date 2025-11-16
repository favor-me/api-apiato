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
use App\Ship\Database\Eloquent\Models\OrganizationModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаления.
 * @property-read Counterparty $organization Связанная модель организации.
 * @property-read Counterparty $counterparty Связанная модель контрагента.
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
