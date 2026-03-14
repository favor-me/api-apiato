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
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(UnitPrice::MODEL);
        $table->unsignedBigInteger(UnitPrice::MODEL_ID);
        $table->unsignedBigInteger(UnitPrice::UNIT_ID);
        $table->unsignedBigInteger(UnitPrice::COST_PRICE)->nullable();
        $table->unsignedBigInteger(UnitPrice::CLIENT_PRICE)->nullable();
        $table->float(UnitPrice::BALANCE)->nullable();
        $table->boolean(UnitPrice::IS_INFINITY_BALANCE)->default(false);

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(UnitPrice::UNIT_ID, $this->getFieldForeignKeyName(UnitPrice::UNIT_ID))
            ->on(OrganizationUnit::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(UnitPrice::UNIT_ID, $this->getFieldIndexName(UnitPrice::UNIT_ID));
        return $this;
    }

    public function getTableName(): string
    {
        return UnitPriceModel::TABLE;
    }
};
