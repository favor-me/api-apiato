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

use App\Containers\AppSection\Authentication\Password\DatabaseTokenRepository;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->string('column')->default(DatabaseTokenRepository::DEFAULT_COLUMN);
            $table->string('value')->index();
            $table->string('token')->index();
            $table->timestamp(CREATED_AT)->nullable();
        });
    }

    public function down(): void
    {
        Schema::drop($this->getTableName());
    }

    public function getTableName(): string
    {
        return 'password_resets';
    }
};
