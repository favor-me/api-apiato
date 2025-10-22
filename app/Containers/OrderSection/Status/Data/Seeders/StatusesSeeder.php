<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\OrderSection\Status\Data\Seeders;

use App\Containers\OrderSection\Status\Dto\CreateStatusDto;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Tasks\CreateStatusTask;
use App\Ship\Parents\Seeders\Seeder;
use App\Ship\Exceptions\CreateResourceFailedException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @description use command a db:seed --class=\\App\\Containers\\OrderSection\\Status\\Data\\Seeders\\StatusesSeeder
 */
class StatusesSeeder extends Seeder
{
    /**
     * @return void
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(): void
    {
        $statuses = collect([
            [
                Status::NAME => 'completed',
                Status::SLUG => 'completed',
                Status::IS_BASE => true
            ],
            [
                Status::NAME => 'canceled',
                Status::SLUG => 'canceled',
                Status::IS_BASE => true
            ],
        ]);

        $statuses
            ->each(function (array $data) {
                $dto = new CreateStatusDto($data);
                app(CreateStatusTask::class)->run($dto);
            });
    }
}
