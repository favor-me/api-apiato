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

namespace App\Containers\CommunitySection\OrganizationClient\Models;

use App\Containers\CommunitySection\Organization\Traits\BelongsToOrganization;
use App\Containers\CommunitySection\OrganizationClient\Data\Factories\OrganizationClientFactory;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient as BaseOrganizationClient;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\DeletedAtAttribute;
use App\Ship\Traits\Model\IsNumbered;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read string $name Имя.
 * @property-read mixed $patronymic Отчество.
 * @property-read mixed $surname Фамилия.
 * @property-read string $full_name Полное имя.
 * @property-read mixed $phone_number Номер телефона.
 * @property-read mixed $note Заметка.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 * @property-read Carbon|null $deleted_at Дата и время удаления.
 *
 * @method static OrganizationClientFactory factory(...$parameters)
 */
class OrganizationClient extends Model
{
    use IsNumbered;
    use SoftDeletes;
    use CreatedAtAttribute;
    use UpdatedAtAttribute;
    use DeletedAtAttribute;
    use BelongsToOrganization;

    public const string TABLE = 'organization_clients';
    public const string RESOURCE_KEY = 'OrganizationClient';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseOrganizationClient::ORGANIZATION_ID,
        BaseOrganizationClient::NAME,
        BaseOrganizationClient::PATRONYMIC,
        BaseOrganizationClient::SURNAME,
        BaseOrganizationClient::PHONE_NUMBER,
        BaseOrganizationClient::NOTE
    ];

    public function fullName(): Attribute
    {
        $fullName = implode(' ', [
            Str::ucfirst($this->surname),
            Str::ucfirst($this->name),
            Str::ucfirst($this->patronymic)
        ]);

        return Attribute::make(get: fn() => $fullName);
    }
}
