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

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger(OrganizationClient::ORGANIZATION_ID);
        $table->string(OrganizationClient::NAME);
        $table->string(OrganizationClient::PATRONYMIC)->nullable();
        $table->string(OrganizationClient::SURNAME)->nullable();
        $table->string(OrganizationClient::PHONE_NUMBER, PhoneNumber::MAX_LENGTH);
        $table->string(OrganizationClient::NOTE)->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(
            OrganizationClient::ORGANIZATION_ID,
            $this->getFieldForeignKeyName(OrganizationClient::ORGANIZATION_ID)
        )
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(
            OrganizationClient::ORGANIZATION_ID,
            $this->getFieldIndexName(OrganizationClient::ORGANIZATION_ID)
        );

        return $this;
    }

    public function getTableName(): string
    {
        return OrganizationClientModel::TABLE;
    }
};
