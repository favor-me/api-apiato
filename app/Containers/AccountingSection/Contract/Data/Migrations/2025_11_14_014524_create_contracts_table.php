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

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(Contract::NAME);
        $table->unsignedBigInteger(Contract::NUMBER);
        $table->unsignedBigInteger(Contract::COUNTERPARTY_ID);
        $table->unsignedBigInteger(Contract::ORGANIZATION_ID);
        $table->date(Contract::START_AT);
        $table->date(Contract::FINISH_AT)->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }


    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign(Contract::COUNTERPARTY_ID, $this->getFieldForeignKeyName(Contract::COUNTERPARTY_ID))
            ->on(Counterparty::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign(Contract::ORGANIZATION_ID, $this->getFieldForeignKeyName(Contract::ORGANIZATION_ID))
            ->on(Organization::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(Contract::COUNTERPARTY_ID, $this->getFieldIndexName(Contract::COUNTERPARTY_ID));
        $table->index(Contract::ORGANIZATION_ID, $this->getFieldIndexName(Contract::ORGANIZATION_ID));

        return $this;
    }

    public function getTableName(): string
    {
        return ContractModel::TABLE;
    }
};
