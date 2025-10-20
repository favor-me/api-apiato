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

use App\Containers\AppSection\User\Models\User;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(ModelNote::TYPE);
        $table->string(ModelNote::MODEL);
        $table->unsignedBigInteger(ModelNote::MODEL_ID);
        $table->unsignedBigInteger(ModelNote::EVENT_ID);
        $table->text(PARAMS)->nullable();
        $table->unsignedBigInteger(CREATED_BY)->nullable();
        $table->unsignedBigInteger(UPDATED_BY)->nullable();
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(ModelNote::EVENT_ID)
            ->references(ID)
            ->on(ModelEvent::TABLE)
            ->cascadeOnDelete();

        $table
            ->foreign(CREATED_BY)
            ->references(ID)
            ->on(User::TABLE)
            ->nullOnDelete();

        $table
            ->foreign(UPDATED_BY)
            ->references(ID)
            ->on(User::TABLE)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(ModelNote::EVENT_ID, $this->getFieldIndexName(ModelNote::EVENT_ID));
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));
        $table->index(UPDATED_BY, $this->getFieldIndexName(UPDATED_BY));

        return $this;
    }

    public function getTableName(): string
    {
        return ModelNoteModel::TABLE;
    }
};
