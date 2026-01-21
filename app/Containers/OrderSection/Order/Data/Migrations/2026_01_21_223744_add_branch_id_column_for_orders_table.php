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

use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
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
            $table
                ->unsignedBigInteger(Order::BRANCH_ID)
                ->nullable()
                ->after(Order::ORGANIZATION_ID);

            $table->foreign(Order::BRANCH_ID, $this->getFieldForeignKeyName(Order::BRANCH_ID))
                ->on(OrganizationBranch::TABLE)
                ->references(ID)
                ->nullOnDelete();

            $table->index(Order::BRANCH_ID, $this->getFieldIndexName(Order::BRANCH_ID));
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropForeign($this->getFieldForeignKeyName(Order::BRANCH_ID));
            $table->dropIndex($this->getFieldIndexName(Order::BRANCH_ID));
            $table->dropColumn(Order::BRANCH_ID);
        });
    }

    public function getTableName(): string
    {
        return OrderModel::TABLE;
    }
};
