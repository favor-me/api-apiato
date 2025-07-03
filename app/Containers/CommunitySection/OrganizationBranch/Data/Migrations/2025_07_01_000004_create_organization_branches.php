<?php

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Database\Migrations\CreateSchemaTable;
use App\Ship\Database\Migrations\CreateTableMigration;
use App\Ship\Support\PhoneNumber;
use Illuminate\Database\Schema\Blueprint;

return new class extends CreateTableMigration {
    public function addTableColumns(Blueprint $table): CreateSchemaTable
    {
        $table->id();
        $table->string('name', Organization::NAME_MAX_LENGTH);
        $table->string('phone_number', PhoneNumber::MAX_LENGTH);
        $table->string('location')->nullable();
        $table->decimal('latitude', 9, 6)->nullable();
        $table->decimal('longitude', 9, 6)->nullable();
        $table->unsignedBigInteger('organization_id');
        $table->unsignedBigInteger('responsible_by')->nullable();
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

        $table->foreign('responsible_by', $this->getFieldForeignKeyName('responsible_by'))
            ->on(UserModel::TABLE)
            ->references(ID)
            ->nullOnDelete();

        return $this;
    }

    public function addTableColumnsIndex(Blueprint $table): CreateSchemaTable
    {
        $table->index('organization_id', $this->getFieldIndexName('organization_id'));
        $table->index('responsible_by', $this->getFieldIndexName('responsible_by'));

        return $this;
    }

    public function getTableName(): string
    {
        return 'organization_branches';
    }
};
