<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\HistorySection\ModelEvent\Models;

use Apiato\Core\Contracts\HasResourceKey;
use App\Containers\HistorySection\ModelEvent\Data\Factories\ModelEventFactory;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\CreatedAtAttribute;
use App\Ship\Traits\Model\UpdatedAtAttribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * TODO - При удалении записи модели удалять все события.
 *
 * @property-read int $id Уникальный идентификатор события.
 * @property-read string $type Тип события.
 * @property-read string $model Класс модели события.
 * @property-read int $model_id Уникальный идентификатор записи модели события.
 * @property-read JSON $data Данные модели до запуска события.
 * @property-read JSON $data_changes Изменённые значения после запуска события.
 * @property-read null|int $created_by Уникальный идентификатор пользователя который создал событие.
 * @property-read Carbon $created_at Дата и время создания события.
 * @property-read Carbon $updated_at Дата и время обновления события.
 *
 * @property-read null|Model $modelObject Объект модели в которой произошло событие.
 *
 * @method static ModelEventFactory factory(...$parameters)
 */
class ModelEvent extends Model implements HasResourceKey
{
    use HasCreatedBy;
    use CreatedAtAttribute;
    use UpdatedAtAttribute;

    public const string TABLE = 'model_events';
    public const string RESOURCE_KEY = 'ModelEvent';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseModelEvent::TYPE,
        BaseModelEvent::MODEL,
        BaseModelEvent::MODEL_ID,
        BaseModelEvent::DATA,
        BaseModelEvent::DATA_CHANGES,
        CREATED_BY
    ];

    protected $casts = [
        BaseModelEvent::DATA => JsonCast::class,
        BaseModelEvent::DATA_CHANGES => JsonCast::class
    ];

    public function modelObject(): BelongsTo
    {
        return $this
            ->belongsTo($this->model, BaseModelEvent::MODEL_ID, ID)
            ->withTrashed();
    }
}
