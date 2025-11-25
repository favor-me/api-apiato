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

namespace App\Ship\Foundation;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Contracts\Namebled;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Exception;
use ReflectionClass;
use ReflectionException;

abstract class AbstractManager
{
    protected Collection $items;

    public function all(): Collection
    {
        return $this->items;
    }

    public function get(string $key): mixed
    {
        if (class_exists($key) && is_subclass_of($key, $this->getItemAccessor())) {
            $key = (new ($key))->getName();
        }

        return $this->items->get($key);
    }

    public static function getInstance(): self
    {
        static $instance = [];

        if (!array_key_exists(static::class, $instance)) {
            $instance[static::class] = new static();
        }

        return $instance[static::class];
    }

    abstract public function getItemAccessor(): string;

    abstract public function getPaths(): array;

    public function has(string $key): bool
    {
        return $this->items->has($key);
    }

    public function isItem(string $className): bool
    {
        try {
            $class = new ReflectionClass($className);

            return $class->isInstantiable() &&
                $class->isSubclassOf($this->getItemAccessor()) &&
                $class->isSubclassOf(Namebled::class);
        } catch (ReflectionException) {
            return false;
        }
    }

    protected function __construct()
    {
        $this->items = collect();
        $this->registerItems();
    }

    protected function findFiles(): Finder
    {
        $finder = new Finder();

        $finder
            ->files()
            ->followLinks()
            ->in($this->getPaths());

        return $finder;
    }

    protected function registerItem(string $className): void
    {
        if ($this->isItem($className)) {
            $this->onRegisterItem($className);
        }
    }

    protected function onRegisterItem(string $className): void
    {
        /** @var Namebled $item */
        $item = new $className();
        $this->putItem($item);
    }

    protected function putItem(Namebled $item): void
    {
        $this->items->put($item->getName(), $item);
    }

    protected function registerItems(): void
    {
        try {
            /** @var SplFileInfo $file */
            foreach ($this->findFiles() as $file) {
                $className = Apiato::getClassFullNameFromFile($file->getPathname());
                $this->registerItem($className);
            }
        } catch (Exception $exception) {
        }
    }
}
