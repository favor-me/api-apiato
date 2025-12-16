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
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            if (Schema::hasColumns($this->getTableName(), ['inn'])) {
                $table->dropIndex($this->getTableName() . '_inn_unique');
                $table->dropColumn('inn');
            }

            $table->dropIndex($this->getTableName() . '_name_unique');

            $table->json(Organization::BANK_DATA)
                ->after(PARAMS)
                ->nullable();

            $table->string(Organization::COUNTRY, Counterparty::COUNTRY_MAX_LENGTH)
                ->after(Organization::BANK_DATA)
                ->default((new RuCountry())->getName());

            $table->string(Organization::OWNERSHIP_TYPE, Organization::OWNERSHIP_TYPE_MAX_LENGTH)
                ->nullable()
                ->after(Organization::COUNTRY);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->index(Organization::NAME, $this->getTableName() . '_name_unique');
            $table->dropColumn(Organization::BANK_DATA);
            $table->dropColumn(Organization::COUNTRY);
            $table->dropColumn(Organization::OWNERSHIP_TYPE);
        });
    }

    public function getTableName(): string
    {
        return OrganizationModel::TABLE;
    }
};
