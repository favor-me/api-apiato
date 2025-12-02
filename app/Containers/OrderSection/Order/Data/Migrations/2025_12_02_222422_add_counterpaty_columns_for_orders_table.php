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

use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $this->createCounterpartyIdColumn($table);
            $this->createContractIdColumn($table);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $this->dropCounterpartyIdColumn($table);
            $this->dropContractIdColumn($table);
        });
    }

    public function getTableName(): string
    {
        return OrderModel::TABLE;
    }

    protected function createContractIdColumn(Blueprint $table): void
    {
        $table
            ->unsignedBigInteger(Order::CONTRACT_ID)
            ->nullable()
            ->after(Order::COUNTERPARTY_ID);

        $table->foreign(Order::CONTRACT_ID, $this->getFieldForeignKeyName(Order::CONTRACT_ID))
            ->on(ContractModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        $table->index(Order::CONTRACT_ID, $this->getFieldIndexName(Order::CONTRACT_ID));
    }

    protected function createCounterpartyIdColumn(Blueprint $table): void
    {
        $table
            ->unsignedBigInteger(Order::COUNTERPARTY_ID)
            ->nullable()
            ->after(Order::CLIENT_ID);

        $table->foreign(Order::COUNTERPARTY_ID, $this->getFieldForeignKeyName(Order::COUNTERPARTY_ID))
            ->on(CounterpartyModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        $table->index(Order::COUNTERPARTY_ID, $this->getFieldIndexName(Order::COUNTERPARTY_ID));
    }

    protected function dropContractIdColumn(Blueprint $table): void
    {
        $table->dropForeign($this->getFieldForeignKeyName(Order::CONTRACT_ID));
        $table->dropIndex($this->getFieldIndexName(Order::CONTRACT_ID));
        $table->dropColumn(Order::CONTRACT_ID);
    }

    protected function dropCounterpartyIdColumn(Blueprint $table): void
    {
        $table->dropForeign($this->getFieldForeignKeyName(Order::COUNTERPARTY_ID));
        $table->dropIndex($this->getFieldIndexName(Order::COUNTERPARTY_ID));
        $table->dropColumn(Order::COUNTERPARTY_ID);
    }
};
