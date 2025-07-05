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

namespace App\Ship\Database\Migrations;

use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class CreateTableMigration extends Migration implements CreateSchemaTable
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        return $this;
    }

    public function createTable(Blueprint $table)
    {
        $this
            ->addTableColumns($table)
            ->addTableColumnsForeign($table)
            ->addTableColumnsIndex($table);
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableName());
    }

    public function up(): void
    {
        $migration = $this;
        Schema::create($this->getTableName(), function (Blueprint $table) use ($migration) {
            $migration->createTable($table);
        });
    }
}
