<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelNote\Models;

use Apiato\Core\Contracts\HasResourceKey;
use App\Containers\AppSection\User\Models\User;
use App\Containers\HistorySection\ModelNote\Data\Factories\ModelNoteFactory;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteType;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteTypeManager;
use App\Ship\Database\Casts\JSON as JsonCast;
use App\Ship\Database\Eloquent\Concerns\HasCreatedBy;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JBZoo\Data\JSON;

/**
 * Class ModelNote - Примечание модели.
 *
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $type Тип.
 * @property-read string $model Класс модели (контекст).
 * @property-read int $model_id Уникальный идентификатор записи модели.
 * @property-read int $event_id Уникальный идентификатор события модели.
 * @property-read JSON $params Дополнительные параметры.
 * @property-read null|int $created_by Уникальный идентификатор пользователя который создал.
 * @property-read null|int $updated_by Уникальный идентификатор пользователя который обновил.
 * @property-read Carbon $created_at Дата и время создания.
 * @property-read Carbon $updated_at Дата и время обновления.
 * @property-read null|User $createdBy Объект пользователя совершивший действие.
 *
 * @method static ModelNoteFactory factory(...$parameters)
 */
final class ModelNote extends Model implements HasResourceKey
{
    use HasCreatedBy;

    public const TABLE = 'model_notes';
    public const RESOURCE_KEY = 'ModelNote';

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        BaseModelNote::TYPE,
        BaseModelNote::MODEL,
        BaseModelNote::MODEL_ID,
        BaseModelNote::EVENT_ID,
        PARAMS,
        CREATED_BY
    ];

    protected $casts = [
        PARAMS => JsonCast::class
    ];

    public function getType(): ModelNoteType
    {
        return ModelNoteTypeManager::getInstance()->get($this->type);
    }

    public function createdBy(): BelongsTo
    {
        return $this
            ->setConnection(config('database.default'))
            ->belongsTo(User::class, $this->getCreatedByColumn(), ID);
    }
}
