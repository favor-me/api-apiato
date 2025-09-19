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

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function getTableName(): string
    {
        return OrderModel::TABLE;
    }

    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();

        $table->unsignedBigInteger(Order::ORGANIZATION_ID);

        $table
            ->unsignedBigInteger(Order::OID)
            ->default(ZERO)
            ->comment('Organization order number');

        $table
            ->string(Order::PAYMENT_TYPE)
            ->nullable();

        $table
            ->unsignedBigInteger(Order::TOTAL)
            ->default(ZERO);

        $table
            ->string(Order::COMMENT)
            ->nullable();

        $table
            ->unsignedBigInteger(Order::CLIENT_ID)
            ->nullable();

        $table
            ->unsignedBigInteger(CREATED_BY)
            ->nullable();

        $table
            ->unsignedBigInteger(UPDATED_BY)
            ->nullable();

        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(
            Order::ORGANIZATION_ID,
            $this->getFieldForeignKeyName(Order::ORGANIZATION_ID)
        )
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table->foreign(Order::CLIENT_ID, $this->getFieldForeignKeyName(Order::CLIENT_ID))
            ->on(OrganizationClientModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        $table->foreign(CREATED_BY, $this->getFieldForeignKeyName(CREATED_BY))
            ->on(UserModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        $table->foreign(UPDATED_BY, $this->getFieldForeignKeyName(UPDATED_BY))
            ->on(UserModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Order::ORGANIZATION_ID, $this->getFieldIndexName(Order::ORGANIZATION_ID));
        $table->index(Order::CLIENT_ID, $this->getFieldIndexName(Order::CLIENT_ID));
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));
        $table->index(UPDATED_BY, $this->getFieldIndexName(UPDATED_BY));

        return $this;
    }
};
