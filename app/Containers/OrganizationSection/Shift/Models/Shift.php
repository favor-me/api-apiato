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

namespace App\Containers\OrganizationSection\Shift\Models;

use Illuminate\Support\Carbon;
use App\Containers\OrganizationSection\Shift\Foundation\Shift as BaseShift;
use App\Containers\OrganizationSection\Shift\Data\Factories\ShiftFactory;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read int $organization_id Уникальный идентификатор организации.
 * @property-read mixed $start_at Дата и время начала смены.
 * @property-read mixed $finish_at Дата и время завершения смены.
 * @property-read int $created_by Уникальный идентификатор пользователя чья смена.
 * @property-read Carbon|null $created_at Дата и время создания.
 * @property-read Carbon|null $updated_at Дата и время обновления.
 *
 * @method static ShiftFactory factory(...$parameters)
 */
class Shift extends Model
{
    use SoftDeletes;
    use IsNumbered;

    public const string TABLE = 'shifts';
    public const string RESOURCE_KEY = 'Shift';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseShift::ORGANIZATION_ID,
        BaseShift::START_AT,
        BaseShift::FINISH_AT,
        CREATED_BY
    ];
}
