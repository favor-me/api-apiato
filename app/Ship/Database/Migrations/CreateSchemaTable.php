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

use Illuminate\Database\Schema\Blueprint;

/**
 * Interface CreateSchemaTable
 *
 * @package App\Ship\Database\Migrations
 */
interface CreateSchemaTable
{
    /**
     * Add table columns.
     *
     * @param   Blueprint $table
     *
     * @return  $this
     */
    public function addTableColumns(Blueprint $table): self;

    /**
     * Add table columns foreign.
     *
     * @param   Blueprint $table
     *
     * @return  $this
     */
    public function addTableColumnsForeign(Blueprint $table): self;

    /**
     * Add table columns index.
     *
     * @param   Blueprint $table
     *
     * @return  $this
     */
    public function addTableColumnsIndex(Blueprint $table): self;

    /**
     * Create migration table.
     *
     * @param   Blueprint $table
     *
     * @return  void
     */
    public function createTable(Blueprint $table);
}
