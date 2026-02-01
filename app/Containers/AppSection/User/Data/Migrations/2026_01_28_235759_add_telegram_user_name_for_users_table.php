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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\TelegramSection\Telegram\Foundation\Telegram;
use App\Ship\Parents\Database\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table
                ->string(User::TELEGRAM_USER_NAME, Telegram::USER_NAME_MAX_LENGTH)
                ->unique(
                    $this->getFieldIndexName(User::TELEGRAM_USER_NAME)
                )
                ->nullable()
                ->after(User::SURNAME);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableName(), function (Blueprint $table) {
            $table->dropColumn(User::TELEGRAM_USER_NAME);
        });
    }

    public function getTableName(): string
    {
        return UserModel::TABLE;
    }
};
