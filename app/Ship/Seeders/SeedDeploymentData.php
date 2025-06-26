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

namespace App\Ship\Seeders;

use App\Ship\Parents\Seeders\Seeder;

final class SeedDeploymentData extends Seeder
{
    /**
     * Note: This seeder is not loaded automatically by Apiato
     * This is a special seeder which can be called by "apiato:seed-deploy" command
     * It is useful for seeding data for initial deployment.
     */
    public function run(): void
    {
        // Create data for live deployment here
    }
}
