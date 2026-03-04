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

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->unsignedBigInteger(Order::SHIFT_ID)
                ->nullable()
                ->after(Order::OID);

            $table->foreign(Order::SHIFT_ID, $this->getFieldForeignKeyName(Order::SHIFT_ID))
                ->on(Shift::TABLE)
                ->references(ID)
                ->nullOnDelete();

            $table->index(Order::SHIFT_ID, $this->getFieldIndexName(Order::SHIFT_ID));
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropForeign($this->getFieldForeignKeyName(Order::SHIFT_ID));
            $table->dropIndex($this->getFieldIndexName(Order::SHIFT_ID));
            $table->dropColumn(Order::SHIFT_ID);
        });
    }

    public function getTableName(): string
    {
        return OrderModel::TABLE;
    }
};
