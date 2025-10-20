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

namespace App\Containers\HistorySection\ModelNote;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\HistorySection\ModelNote\Contracts\ModelNoteManager as ModelNoteManagerContract;
use App\Ship\Foundation\AbstractManager;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;

class ModelNoteManager extends AbstractManager
{
    public const PREFIX = 'ModelNoteManager';

    public function get(string $key): ?ModelNoteManagerContract
    {
        if (class_exists($key)) {
            $key = $key::getKey();
        }

        return parent::get($key);
    }

    public function toList(): Collection
    {
        return $this
            ->all()
            ->flatMap(fn (ModelNoteManagerContract $noteManager) => [
                [
                    'title' => $noteManager->getName(),
                    'value' => $noteManager->getModel()
                ]
            ]);
    }

    public function getItemAccessor(): string
    {
        return ModelNoteManagerContract::class;
    }

    public function getPaths(): array
    {
        return Apiato::getAllContainerPaths();
    }

    protected function findFiles(): Finder
    {
        return parent::findFiles()
            ->notName('/^' . self::PREFIX . '\.php/')
            ->notName('/^ModelNoteManager\.php/')
            ->name('*' . self::PREFIX . '.php');
    }

    public function isItem(string $className): bool
    {
        try {
            $class = new ReflectionClass($className);

            return $class->isInstantiable() &&
                $class->isSubclassOf($this->getItemAccessor());
        } catch (ReflectionException) {
            return false;
        }
    }

    protected function onRegisterItem(string $className): void
    {
        /** @var ModelNoteManagerContract $item */
        $item = new $className();
        $this->items->put($item->getModel(), $item);
    }
}
