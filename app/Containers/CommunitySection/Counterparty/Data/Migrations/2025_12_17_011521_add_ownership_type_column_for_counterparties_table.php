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

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->string(Counterparty::OWNERSHIP_TYPE, Counterparty::OWNERSHIP_TYPE_MAX_LENGTH)
                ->nullable()
                ->after(Counterparty::NAME);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropColumn(Counterparty::COUNTRY);
        });
    }

    public function getTableName(): string
    {
        return CounterpartyModel::TABLE;
    }
};
