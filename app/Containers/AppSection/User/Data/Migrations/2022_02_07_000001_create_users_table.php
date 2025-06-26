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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string(User::LOGIN, User::NAME_MAX_LENGTH)
            ->nullable()
            ->unique($this->getFieldIndexName(User::LOGIN));
        $table->string(User::NAME, User::NAME_MAX_LENGTH);
        $table->string(User::PATRONYMIC, User::PATRONYMIC_MAX_LENGTH)->nullable();
        $table->string(User::SURNAME, User::SURNAME_MAX_LENGTH)->nullable();
        $table->boolean(User::GENDER)->nullable();
        $table->date(User::BIRTH)->nullable();
        $table->string(User::AVATAR, User::AVATAR_MAX_LENGTH)->nullable();
        $table->string(User::EMAIL, User::EMAIL_MAX_LENGTH)
            ->unique()
            ->nullable();
        $table->string(User::PHONE_NUMBER, User::PHONE_NUMBER_MAX_LENGTH)
            ->unique()
            ->nullable();
        $table->timestamp(User::EMAIL_VERIFIED_AT)->nullable();
        $table->timestamp(User::PHONE_NUMBER_VERIFIED_AT)->nullable();
        $table->boolean(User::IS_ADMIN)->default(false);
        $table->rememberToken();
        $table->string(User::PASSWORD);
        $table->json(PARAMS)->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        return $this;
    }

    public function getTableName(): string
    {
        return UserModel::TABLE;
    }
};
