<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Models;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit as BaseOrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Data\Factories\OrganizationUnitFactory;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read mixed $name Имя.
 * @property-read mixed $type
 * @property-read mixed $sku
 * @property-read mixed $ordering Значение для сортировки.
 * @property-read mixed $params
 * @property-read mixed $cost_price
 * @property-read mixed $price_up
 * @property-read mixed $client_price
 * @property-read mixed $balance
 * @property-read int $organization_id Уникальный идентификатор.
 * @property-read int $system_unit_id Уникальный идентификатор.
 * @property-read mixed $created_at Дата и время создания.
 * @property-read mixed $updated_at Дата и время обновления.
 * @property-read mixed $deleted_at Дата и время удаления.
 *
 * @method static OrganizationUnitFactory factory(...$parameters)
 */
class OrganizationUnit extends Model
{
    use SoftDeletes;
    use IsNumbered;

    public const TABLE = 'organization_units';
    public const RESOURCE_KEY = 'OrganizationUnit';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseOrganizationUnit::NAME,
        BaseOrganizationUnit::TYPE,
        BaseOrganizationUnit::SKU,
        BaseOrganizationUnit::ORDERING,
        PARAMS,
        BaseOrganizationUnit::COST_PRICE,
        BaseOrganizationUnit::PRICE_UP,
        BaseOrganizationUnit::CLIENT_PRICE,
        BaseOrganizationUnit::BALANCE,
        BaseOrganizationUnit::ORGANIZATION_ID,
        BaseOrganizationUnit::SYSTEM_UNIT_ID
    ];
}
