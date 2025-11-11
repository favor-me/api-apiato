<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\CommunitySection\OrganizationUnitType;

use App\Containers\CommunitySection\OrganizationUnitType\Facades\Container;
use App\Ship\Foundation\AbstractManager;
use Symfony\Component\Finder\Finder;

/**
 * @method null|Type get(string $key)
 * @method static Manager getInstance()
 */
class Manager extends AbstractManager
{
    public const string PREFIX = 'Type';

    public function getItemAccessor(): string
    {
        return Type::class;
    }

    public function getPaths(): array
    {
        return [
            Container::getPath()
        ];
    }

    protected function findFiles(): Finder
    {
        return parent::findFiles()
            ->notName('/^' . self::PREFIX . '\.php/')
            ->notName('/^Manager\.php/')
            ->name('*' . self::PREFIX . '.php');
    }
}
