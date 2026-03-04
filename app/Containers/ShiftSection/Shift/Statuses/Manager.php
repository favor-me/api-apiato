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

namespace App\Containers\ShiftSection\Shift\Statuses;

use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Foundation\AbstractManager;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

/**
 * @method null|Status get(string $key)
 * @method static Manager getInstance()
 */
final class Manager extends AbstractManager
{
    public const string PREFIX = 'Status';

    public function getItemAccessor(): string
    {
        return Status::class;
    }

    public function getPaths(): array
    {
        return [
            Container::getPath(Str::plural(self::PREFIX))
        ];
    }

    public function getShiftStatus(ShiftModel $shift): Status
    {
        $now = now()->utc();
        if ($now->gt($shift->finish_at)) {
            return $this->get(CompletedStatus::class);
        } elseif ($now->gte($shift->start_at) && $now->lte($shift->finish_at)) {
            return $this->get(OpenStatus::class);
        }

        return $this->get(UnknownStatus::class);
    }

    protected function findFiles(): Finder
    {
        return parent::findFiles()
            ->notName('/^' . self::PREFIX . '\.php/')
            ->notName('/^Manager\.php/')
            ->name('*' . self::PREFIX . '.php');
    }
}
