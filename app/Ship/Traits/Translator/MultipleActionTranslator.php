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

namespace App\Ship\Traits\Translator;

use Illuminate\Support\Str;

trait MultipleActionTranslator
{
    abstract public static function getMultipleItemsKey(): string;

    public static function getDeletedMultipleMessage(int $count): string
    {
        return trans_choice('action.deleted_multiple', $count, [
            'deletes' => Str::lower(trans_choice('core.' . static::gender() . '_deletes', $count)),
            'items' => Str::lower(trans_choice(self::getMultipleItemsKey(), $count))
        ]);
    }

    public static function getRestoredMultipleMessage(int $count): string
    {
        return trans_choice('action.restored_multiple', $count, [
            'restores' => Str::lower(trans_choice('core.' . static::gender() . '_restored', $count)),
            'items' => Str::lower(trans_choice(self::getMultipleItemsKey(), $count))
        ]);
    }

    public static function getTrashedMultipleMessage(int $count): string
    {
        return trans_choice('action.trashed_multiple', $count, [
            'moved' => Str::lower(trans_choice('core.' . static::gender() . '_moved', $count)),
            'items' => Str::lower(trans_choice(self::getMultipleItemsKey(), $count))
        ]);
    }

    public static function getUpdatedMultipleMessage(int $count): string
    {
        return trans_choice('action.updated_multiple', $count, [
            'updates' => Str::lower(trans_choice('core.' . static::gender() . '_updates', $count)),
            'items' => Str::lower(trans_choice(self::getMultipleItemsKey(), $count))
        ]);
    }

    public static function gender(): string
    {
        return 'male';
    }
}
