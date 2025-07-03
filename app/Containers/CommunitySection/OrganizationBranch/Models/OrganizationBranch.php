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

namespace App\Containers\CommunitySection\OrganizationBranch\Models;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Data\Factories\OrganizationBranchFactory;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch as BaseOrganizationBranch;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read mixed $name Имя.
 * @property-read mixed $phone_number
 * @property-read mixed $location
 * @property-read mixed $latitude
 * @property-read mixed $longitude
 * @property-read int $organization_id Уникальный идентификатор организации.
 * @property-read int $responsible_by Уникальный идентификатор ответственно пользователя.
 * @property-read null|OrganizationModel $organization Модель связанной организации.
 * @property-read null|UserModel $responsible Модель ответственно пользователя.
 * @property-read mixed $created_at Дата и время создания.
 * @property-read mixed $updated_at Дата и время обновления.
 * @property-read mixed $deleted_at Дата и время удаления.
 *
 * @method static OrganizationBranchFactory factory(...$parameters)
 */
class OrganizationBranch extends Model
{
    use SoftDeletes;
    use IsNumbered;

    public const TABLE = 'organization_branches';
    public const RESOURCE_KEY = 'OrganizationBranch';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseOrganizationBranch::NAME,
        BaseOrganizationBranch::PHONE_NUMBER,
        BaseOrganizationBranch::LOCATION,
        BaseOrganizationBranch::LATITUDE,
        BaseOrganizationBranch::LONGITUDE,
        BaseOrganizationBranch::ORGANIZATION_ID,
        BaseOrganizationBranch::RESPONSIBLE_BY
    ];

    protected $casts = [
        BaseOrganizationBranch::LATITUDE => 'float',
        BaseOrganizationBranch::LONGITUDE => 'float',
        BaseOrganizationBranch::PHONE_NUMBER => 'int',
        CREATED_AT => 'datetime',
        UPDATED_AT => 'datetime',
        DELETED_AT => 'datetime'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(OrganizationModel::class, BaseOrganizationBranch::ORGANIZATION_ID, ID);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, BaseOrganizationBranch::ORGANIZATION_ID, ID);
    }
}
