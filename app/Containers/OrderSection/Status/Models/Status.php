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

namespace App\Containers\OrderSection\Status\Models;

use App\Containers\OrderSection\Status\Data\Factories\StatusFactory;
use App\Containers\OrderSection\Status\Facades\Container;
use App\Ship\Parents\Models\Model;
use App\Ship\Traits\Model\IsNumbered;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property-read int $id Уникальный идентификатор.
 * @property-read string $name Имя.
 * @property-read mixed $slug Псевдоним.
 * @property-read mixed $is_base
 * @property-read mixed $params
 *
 * @method static StatusFactory factory(...$parameters)
 */
class Status extends Model
{
    use IsNumbered;

    public const COMPLETED = 'completed';
    public const CANCELED = 'canceled';
    public const TABLE = 'order_statuses';
    public const RESOURCE_KEY = 'Status';

    public $timestamps = false;

    protected $table = self::TABLE;
    protected string $resourceKey = self::RESOURCE_KEY;

    protected $fillable = [
        'name',
        'slug',
        'is_base',
        PARAMS
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $transKey = 'container.' . $value;
                if (app('translator')->has(Container::transFullKey($transKey))) {
                    return Container::trans($transKey);
                }

                return $value;
            }
        );
    }
}
