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

namespace App\Containers\CommunitySection\Counterparty\Models;

use App\Containers\CommunitySection\Counterparty\Casts\CounterpartyCountry as CounterpartyCountryCast;
use App\Containers\OrganizationSection\OwnershipType\Casts\OwnershipType as OwnershipTypeCast;
use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Data\Factories\CounterpartyFactory;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty as BaseCounterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\OrganizationSection\OwnershipType\Type as OwnershipType;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\DeletedAtAttribute;
use App\Ship\Traits\Model\IsNumbered;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $name Имя.
 * @property-read null|OwnershipType $ownership_type Тип собственности.
 * @property-read string $legal_address Юридический адрес.
 * @property-read string $mailing_address Почтовый адрес.
 * @property-read int $phone_number Номер телефона.
 * @property-read string|null $email Адрес электронной почты.
 * @property-read Country $country Страна.
 * @property-read JSON $bank_data Реквизиты банка.
 * @property-read int $organization_id Уникальный идентификатор организации.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаленияу.
 * @property-read Organization $organization Связанная модель организации.
 *
 * @method static CounterpartyFactory factory(...$parameters)
 */
class Counterparty extends Model
{
    use SoftDeletes;
    use IsNumbered;
    use CreatedAtAttribute;
    use UpdatedAtAttribute;
    use DeletedAtAttribute;

    public const string TABLE = 'counterparties';
    public const string RESOURCE_KEY = 'Counterparty';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseCounterparty::NAME,
        BaseCounterparty::LEGAL_ADDRESS,
        BaseCounterparty::MAILING_ADDRESS,
        BaseCounterparty::PHONE_NUMBER,
        BaseCounterparty::EMAIL,
        BaseCounterparty::COUNTRY,
        BaseCounterparty::BANK_DATA,
        BaseCounterparty::ORGANIZATION_ID,
        BaseCounterparty::OWNERSHIP_TYPE
    ];

    protected $casts = [
        BaseCounterparty::PHONE_NUMBER => 'int',
        BaseCounterparty::BANK_DATA => JsonCast::class,
        BaseCounterparty::COUNTRY => CounterpartyCountryCast::class,
        BaseCounterparty::OWNERSHIP_TYPE => OwnershipTypeCast::class
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, BaseCounterparty::ORGANIZATION_ID, ID);
    }
}
