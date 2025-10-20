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

namespace App\Containers\HistorySection\ModelNote\Types;

use App\Containers\HistorySection\ModelNote\Facades\Container;
use App\Ship\Foundation\AbstractManager;
use Symfony\Component\Finder\Finder;

/**
 * @method static ModelNoteTypeManager getInstance()
 */
class ModelNoteTypeManager extends AbstractManager
{
    public const PREFIX = 'ModelNoteType';

    public function get(string $key): ?ModelNoteType
    {
        if (class_exists($key)) {
            $key = $key::getKey();
        }

        return parent::get($key);
    }

    public function getItemAccessor(): string
    {
        return ModelNoteType::class;
    }

    public function getPaths(): array
    {
        return [Container::getPath('Types')];
    }

    protected function findFiles(): Finder
    {
        return parent::findFiles()
            ->notName('/^' . self::PREFIX . '\.php/')
            ->notName('/^ModelNoteTypeManager\.php/')
            ->name('*' . self::PREFIX . '.php');
    }
}
