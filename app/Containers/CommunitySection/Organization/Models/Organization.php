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

namespace App\Containers\CommunitySection\Organization\Models;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Data\Factories\OrganizationFactory;
use App\Containers\CommunitySection\Organization\Foundation\Organization as BaseOrganization;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $name Название.
 * @property-read string|null $inn ИНН.
 * @property-read int $phone_number Контактный номер телефона.
 * @property-read int $user_owner_id Уникальный идентификатор пользователя который владеет компанией.
 * @property-read string|null $email Адрес электронной почты.
 * @property-read JSON $params Дополнительные параметры.
 * @property-read null|Carbon $created_at Дата и время создания.
 * @property-read null|Carbon $updated_at Дата и время обновления.
 * @property-read null|Carbon $deleted_at Дата и время удаления.
 * @property-read UserModel $userOwner Объект пользователя который владеет компанией.
 *
 * @method static OrganizationFactory factory(...$parameters)
 */
class Organization extends Model
{
    use SoftDeletes;
    use IsNumbered;

    public const TABLE = 'organizations';
    public const RESOURCE_KEY = 'Organization';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseOrganization::NAME,
        BaseOrganization::INN,
        BaseOrganization::PHONE_NUMBER,
        BaseOrganization::EMAIL,
        BaseOrganization::USER_OWNER_ID,
        PARAMS
    ];

    protected $casts = [
        BaseOrganization::PHONE_NUMBER => 'int',
        PARAMS => JsonCast::class,
        CREATED_AT => 'datetime',
        UPDATED_AT => 'datetime',
        DELETED_AT => 'datetime'
    ];

    public function userOwner(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, BaseOrganization::USER_OWNER_ID, ID);
    }
}
