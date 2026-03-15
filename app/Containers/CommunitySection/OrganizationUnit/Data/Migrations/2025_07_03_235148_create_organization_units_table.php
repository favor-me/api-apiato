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

use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\Vendor\Unit\Models\Unit as UnitModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(OrganizationUnit::NAME);
        $table->string(OrganizationUnit::TYPE);
        $table->string(OrganizationUnit::SKU)->nullable();
        $table->unsignedInteger(OrganizationUnit::ORDERING)->default(ZERO);
        $table->json(PARAMS)->nullable();
        $table->unsignedBigInteger(UnitPrice::COST_PRICE)->nullable();
        $table->unsignedBigInteger(UnitPrice::CLIENT_PRICE)->nullable();
        $table->float(UnitPrice::BALANCE)->nullable();
        $table->boolean(UnitPrice::IS_INFINITY_BALANCE)->default(false);
        $table->unsignedBigInteger(OrganizationUnit::ORGANIZATION_ID);
        $table->unsignedBigInteger(OrganizationUnit::SYSTEM_UNIT_ID)->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(
            OrganizationUnit::ORGANIZATION_ID,
            $this->getFieldForeignKeyName(OrganizationUnit::ORGANIZATION_ID)
        )
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table->foreign(
            OrganizationUnit::SYSTEM_UNIT_ID,
            $this->getFieldForeignKeyName(OrganizationUnit::SYSTEM_UNIT_ID)
        )
            ->on(UnitModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(OrganizationUnit::ORGANIZATION_ID, $this->getFieldIndexName(OrganizationUnit::ORGANIZATION_ID));
        $table->index(OrganizationUnit::SYSTEM_UNIT_ID, $this->getFieldIndexName(OrganizationUnit::SYSTEM_UNIT_ID));

        return $this;
    }

    public function getTableName(): string
    {
        return OrganizationUnitModel::TABLE;
    }
};
