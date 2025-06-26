<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Parents\Database\Migrations;

use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Support\Str;

abstract class Migration extends BaseMigration
{
    protected string $fieldIndexPostfix = '_index';
    protected string $fieldForeignKeyPostfix = '_fk';

    abstract public function getTableName(): string;

    protected function getFieldKeyName(string $field): string
    {
        $field = Str::lower($field);
        return $this->getKeyNamePrefix() . '_' . $field;
    }

    protected function getFieldIndexName(string $field): string
    {
        return $this->getFieldKeyName($field . $this->fieldIndexPostfix);
    }

    protected function getFieldForeignKeyName(string $field): string
    {
        return $this->getFieldKeyName($field . $this->fieldForeignKeyPostfix);
    }

    protected function getKeyNamePrefix(): string
    {
        return Str::singular($this->getTableName());
    }
}
