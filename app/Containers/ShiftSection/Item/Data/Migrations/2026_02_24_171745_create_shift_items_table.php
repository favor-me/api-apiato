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

use App\Containers\AppSection\User\Models\User;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger(Item::SHIFT_ID);
        $table->unsignedBigInteger(Item::ORDER_ID)->nullable();
        $table->string(Item::TYPE, Item::TYPE_MAX_LENGTH);
        $table->bigInteger(Item::VALUE)->default(ZERO);
        $table->string(Item::DESCRIPTION, SCHEMA_DEFAULT_STRING_LENGTH)->nullable();
        $table->unsignedBigInteger(CREATED_BY)->nullable();
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(Item::SHIFT_ID, $this->getFieldForeignKeyName(Item::SHIFT_ID))
            ->on(Shift::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign(Item::ORDER_ID, $this->getFieldForeignKeyName(Item::ORDER_ID))
            ->on(Order::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign(CREATED_BY, $this->getFieldForeignKeyName(CREATED_BY))
            ->on(User::TABLE)
            ->references(ID)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Item::SHIFT_ID, $this->getFieldIndexName(Item::SHIFT_ID));
        $table->index(Item::ORDER_ID, $this->getFieldIndexName(Item::ORDER_ID));
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));

        return $this;
    }

    public function getTableName(): string
    {
        return ItemModel::TABLE;
    }
};
