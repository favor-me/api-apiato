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

use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Parents\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->unsignedBigInteger(User::ORGANIZATION_BRANCH_ID)
                ->nullable()
                ->after(PARAMS);

            $table->foreign(User::ORGANIZATION_BRANCH_ID, $this->getFieldForeignKeyName(User::ORGANIZATION_BRANCH_ID))
                ->on(OrganizationBranchModel::TABLE)
                ->references(ID)
                ->cascadeOnDelete();

            $table->index(User::ORGANIZATION_BRANCH_ID, $this->getFieldIndexName(User::ORGANIZATION_BRANCH_ID));
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropColumn(User::ORGANIZATION_BRANCH_ID);
        });
    }

    public function getTableName(): string
    {
        return UserModel::TABLE;
    }
};
