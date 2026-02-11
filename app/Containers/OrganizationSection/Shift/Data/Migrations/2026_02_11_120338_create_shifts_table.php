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

use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration
{
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger('organization_id');
        $table->date('start_at');
        $table->date('finish_at');
        $table->unsignedBigInteger('created_by');
        $table->timestamps();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table
            ->foreign('organization_id', $this->getFieldForeignKeyName('organization_id'))
            ->on(Organization::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        $table
            ->foreign('created_by', $this->getFieldForeignKeyName('created_by'))
            ->on(User::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index('organization_id', $this->getFieldIndexName('organization_id'));
        $table->index('created_by', $this->getFieldIndexName('created_by'));

        return $this;
    }

    public function getTableName(): string
    {
        return 'shifts';
    }
};
