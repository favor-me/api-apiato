<?php

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->unsignedBigInteger('organization_id');
        $table->string('name');
        $table->string('patronymic')->nullable();
        $table->string('surname')->nullable();
        $table->string('phone_number', PhoneNumber::MAX_LENGTH);
        $table->string('note')->nullable();
        $table->timestamps();
        $table->softDeletes();

        return $this;
    }

    public function addTableColumnsForeign(Blueprint $table): CreateSchemaTable
    {
        $table->foreign('organization_id', $this->getFieldForeignKeyName('organization_id'))
            ->on(OrganizationModel::TABLE)
            ->references(ID)
            ->cascadeOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index('organization_id', $this->getFieldIndexName('organization_id'));
        return $this;
    }

    public function getTableName(): string
    {
        return 'organization_clients';
    }
};
