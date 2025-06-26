<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevices;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger(BaseUser::ID);
        $table->string(BaseUserDevices::MODEL, BaseUserDevices::MODEL_MAX_LENGTH);
        $table->string(BaseUserDevices::TOKEN);
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign(BaseUser::ID, $this->getFieldForeignKeyName(BaseUser::ID))
            ->on(User::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index(BaseUser::ID, $this->getFieldIndexName(BaseUser::ID));
        return $this;
    }

    public function getTableName(): string
    {
        return UserDevice::TABLE;
    }
};
