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
use App\Containers\OrganizationSection\Shift\Models\Shift;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger('shift_id');
        $table->unsignedBigInteger('order_id')->nullable();
        $table->string('type', 50);
        $table->bigInteger('value')->default(ZERO);
        $table->string('description', SCHEMA_DEFAULT_STRING_LENGTH)->nullable();
        $table->unsignedBigInteger(CREATED_BY)->nullable();
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign('shift_id', $this->getFieldForeignKeyName('shift_id'))
            ->on(Shift::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign('order_id', $this->getFieldForeignKeyName('order_id'))
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
        $table->index('shift_id', $this->getFieldIndexName('shift_id'));
        $table->index('order_id', $this->getFieldIndexName('order_id'));
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));

        return $this;
    }

    public function getTableName(): string
    {
        return 'shift_items';
    }
};
