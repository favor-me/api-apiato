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
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger(Shift::ORGANIZATION_ID);
        $table->unsignedBigInteger(Shift::ORGANIZATION_BRANCH_ID)->nullable();
        $table->dateTime(Shift::START_AT);
        $table->dateTime(Shift::FINISH_AT);
        $table->unsignedBigInteger(CREATED_BY);
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(Shift::ORGANIZATION_ID, $this->getFieldForeignKeyName(Shift::ORGANIZATION_ID))
            ->on(Organization::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign(Shift::ORGANIZATION_BRANCH_ID, $this->getFieldForeignKeyName(Shift::ORGANIZATION_BRANCH_ID))
            ->on(OrganizationBranch::TABLE)
            ->references(ID)
            ->nullOnDelete();

        $table
            ->foreign(CREATED_BY, $this->getFieldForeignKeyName(CREATED_BY))
            ->on(User::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Shift::ORGANIZATION_ID, $this->getFieldIndexName(Shift::ORGANIZATION_ID));
        $table->index(Shift::ORGANIZATION_BRANCH_ID, $this->getFieldIndexName(Shift::ORGANIZATION_BRANCH_ID));
        $table->index(CREATED_BY, $this->getFieldIndexName(CREATED_BY));

        return $this;
    }

    public function getTableName(): string
    {
        return ShiftModel::TABLE;
    }
};
