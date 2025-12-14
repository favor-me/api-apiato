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

namespace App\Containers\OrganizationSection\OwnershipType;

use App\Containers\OrganizationSection\OwnershipType\Facades\Container;
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
