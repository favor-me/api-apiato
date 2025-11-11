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

use App\Ship\Support\Email;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(Counterparty::NAME);
        $table->string(Counterparty::LEGAL_ADDRESS);
        $table->string(Counterparty::MAILING_ADDRESS);
        $table->string(Counterparty::PHONE_NUMBER, PhoneNumber::MAX_LENGTH);
        $table->string(Counterparty::EMAIL, Email::MAX_LENGTH)->nullable();
        $table->string(Counterparty::COUNTRY, Counterparty::COUNTRY_MAX_LENGTH);
        $table->json(Counterparty::BANK_DATA)->nullable();
        $table->unsignedBigInteger(Counterparty::ORGANIZATION_ID);
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(
                Counterparty::ORGANIZATION_ID,
                $this->getFieldForeignKeyName(Counterparty::ORGANIZATION_ID)
            )
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Counterparty::ORGANIZATION_ID, $this->getFieldIndexName(Counterparty::ORGANIZATION_ID));

        return $this;
    }

    public function getTableName(): string
    {
        return CounterpartyModel::TABLE;
    }
};
