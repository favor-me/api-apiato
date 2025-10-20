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

use App\Containers\AppSection\User\Models\User;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent as ModelEventModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(ModelEvent::TYPE);
        $table->string(ModelEvent::MODEL);
        $table->unsignedBigInteger(ModelEvent::MODEL_ID);
        $table->text(ModelEvent::DATA);
        $table->text(ModelEvent::DATA_CHANGES);
        $table->unsignedBigInteger(CREATED_BY)->nullable();
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(CREATED_BY)
            ->references(ID)
            ->on(User::TABLE)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));

        return $this;
    }

    public function getTableName(): string
    {
        return ModelEventModel::TABLE;
    }
};
