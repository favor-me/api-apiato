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

use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Models\Order;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger(Item::ORDER_ID);
        $table->unsignedBigInteger(Item::UNIT_ID)->nullable();
        $table->string(Item::NAME);
        $table->string(Item::SKU)->nullable();
        $table->unsignedBigInteger(Item::COST_PRICE)->nullable();
        $table->unsignedBigInteger(Item::CLIENT_PRICE)->nullable();
        $table->float(Item::AMOUNT)->default(1);

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(Item::ORDER_ID, $this->getFieldForeignKeyName(Item::ORDER_ID))
            ->on(Order::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table->foreign(Item::UNIT_ID, $this->getFieldForeignKeyName(Item::UNIT_ID))
            ->on(OrganizationUnit::TABLE)
            ->references(ID)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Item::ORDER_ID, $this->getFieldIndexName(Item::ORDER_ID));
        $table->index(Item::UNIT_ID, $this->getFieldIndexName(Item::UNIT_ID));

        return $this;
    }

    public function getTableName(): string
    {
        return ItemModel::TABLE;
    }
};
