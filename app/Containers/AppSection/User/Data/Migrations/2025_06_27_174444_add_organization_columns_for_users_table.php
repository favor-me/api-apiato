<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */


use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Parents\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->unsignedBigInteger(User::ORGANIZATION_ID)
                ->nullable()
                ->after(PARAMS);

            $table
                ->boolean(User::IS_ORGANIZATION_OWNER)
                ->default(false)
                ->after(User::IS_ADMIN);

            $table->foreign(User::ORGANIZATION_ID, $this->getFieldForeignKeyName(User::ORGANIZATION_ID))
                ->on(OrganizationModel::TABLE)
                ->references(ID)
                ->cascadeOnDelete();

            $table->index(User::ORGANIZATION_ID, $this->getFieldIndexName(User::ORGANIZATION_ID));
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropColumn(User::ORGANIZATION_ID);
            $table->dropColumn(User::IS_ORGANIZATION_OWNER);
        });
    }

    public function getTableName(): string
    {
        return UserModel::TABLE;
    }
};
