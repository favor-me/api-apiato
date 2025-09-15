<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\Vendor\Data\Seeders;

use App\Containers\Vendor\Unit\Foundation\Unit;
use App\Containers\Vendor\Unit\Models\Unit as UnitModel;
use App\Containers\Vendor\Unit\Tasks\CreateUnitTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * @codingStandardsIgnoreStart
 */
class UnitSeeder extends Seeder
{
    /**
     * @throws CreateResourceFailedException
     */
    public function run(): void
    {
        $task = app(CreateUnitTask::class);
        foreach ($this->getDefaultUnits() as $unitName) {
            $existsUnit = DB::table(UnitModel::TABLE)
                ->where(Unit::NAME, $unitName)
                ->exists();

            if (!$existsUnit) {
                $task->run($unitName);
            }
        }
    }

    protected function getDefaultUnits(): array
    {
        return [
            'шт.',
            'упак.'
        ];
    }
}
