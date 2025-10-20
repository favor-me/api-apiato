<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Search;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Search
{
    protected ?string $tableField;
    protected ?string $field;
    protected Builder $query;
    protected ?string $value;
    protected string $whereMode;

    public function __construct(Builder $query, $field, $value, string $whereMode)
    {
        $tableName = $query->getModel()->getTable();
        $this->query = $query;
        $this->field = $field;
        $this->tableField = $tableName . '.' . $field;
        $this->value = $value;
        $this->whereMode = Str::lower($whereMode);
        $this->initialize();
    }

    public function initialize(): void
    {
    }

    abstract public function __invoke(): void;
}
