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
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(OrganizationBranch::NAME, Organization::NAME_MAX_LENGTH);
        $table->string(OrganizationBranch::PHONE_NUMBER, PhoneNumber::MAX_LENGTH);
        $table->string(OrganizationBranch::LOCATION)->nullable();
        $table->decimal(OrganizationBranch::LATITUDE, 9, 6)->nullable();
        $table->decimal(OrganizationBranch::LONGITUDE, 9, 6)->nullable();
        $table->unsignedBigInteger(OrganizationBranch::ORGANIZATION_ID);
        $table->unsignedBigInteger(OrganizationBranch::RESPONSIBLE_BY)->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(
            OrganizationBranch::ORGANIZATION_ID,
            $this->getFieldForeignKeyName(OrganizationBranch::ORGANIZATION_ID)
        )
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table->foreign(
            OrganizationBranch::RESPONSIBLE_BY,
            $this->getFieldForeignKeyName(OrganizationBranch::RESPONSIBLE_BY)
        )
            ->on(UserModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(
            OrganizationBranch::ORGANIZATION_ID,
            $this->getFieldIndexName(OrganizationBranch::ORGANIZATION_ID)
        );

        $table->index(
            OrganizationBranch::RESPONSIBLE_BY,
            $this->getFieldIndexName(OrganizationBranch::RESPONSIBLE_BY)
        );

        return $this;
    }

    public function getTableName(): string
    {
        return OrganizationBranchModel::TABLE;
    }
};
