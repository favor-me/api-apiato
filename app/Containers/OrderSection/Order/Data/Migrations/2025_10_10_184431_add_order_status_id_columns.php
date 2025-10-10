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

use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;

return new class extends Migration {
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->unsignedBigInteger(Order::STATUS_ID)
                ->nullable()
                ->after(Order::OID);

            $table->foreign(Order::STATUS_ID, $this->getFieldForeignKeyName(Order::STATUS_ID))
                ->on(StatusModel::TABLE)
                ->references(ID)
                ->nullOnDelete();

            $table->index(Order::STATUS_ID, $this->getFieldIndexName(Order::STATUS_ID));

            $table
                ->datetime(Order::COMPLETED_AT)
                ->nullable()
                ->after(UPDATED_BY);

            $table
                ->datetime(Order::CANCELED_AT)
                ->nullable()
                ->after(Order::COMPLETED_AT);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropForeign($this->getFieldForeignKeyName(Order::STATUS_ID));
            $table->dropIndex($this->getFieldIndexName(Order::STATUS_ID));
            $table->dropColumn(Order::STATUS_ID);
            $table->dropColumn(Order::COMPLETED_AT);
            $table->dropColumn(Order::CANCELED_AT);
        });
    }

    public function getTableName(): string
    {
        return OrderModel::TABLE;
    }
};
