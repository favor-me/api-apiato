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
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\Email;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();

        $table->unsignedBigInteger(Organization::USER_OWNER_ID);

        $table
            ->string(Organization::NAME, Organization::NAME_MAX_LENGTH)
            ->unique();

        $table->string(Organization::PHONE_NUMBER, PhoneNumber::MAX_LENGTH)
            ->unique()
            ->nullable();

        $table->string(Organization::EMAIL, Email::MAX_LENGTH)
            ->unique()
            ->nullable();

        $table->json(PARAMS)
            ->nullable();

        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(Organization::USER_OWNER_ID, $this->getFieldForeignKeyName(Organization::USER_OWNER_ID))
            ->on(UserModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Organization::USER_OWNER_ID, $this->getFieldIndexName(Organization::USER_OWNER_ID));
        return $this;
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableName());
    }

    public function getTableName(): string
    {
        return OrganizationModel::TABLE;
    }
};
