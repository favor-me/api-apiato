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

namespace App\Ship\Helpers\Classes;

use ReflectionException;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class Manager
 *
 * @pakage App\Ship\Helpers\Classes
 */
class Manager
{
    public const CONTAINER_NAME = 'helper';

    public const HELPER_PREFIX = 'Helper';

    /**
     * All loaded helpers.
     *
     * @var array
     */
    protected array $loaded = [];

    /**
     * Get helper key name.
     *
     * @param   string $className
     *
     * @return  string
     *
     * @throws  ReflectionException
     */
    public static function getHelperKeyName(string $className): string
    {
        $reflection = new \ReflectionClass($className);
        $kebabName  = Str::kebab($reflection->getShortName());

        return str_replace('-' . Str::lower(self::HELPER_PREFIX), null, $kebabName);
    }

    /**
     * Get all loaded helpers.
     *
     * @return array
     */
    public function getLoaded(): array
    {
        return $this->loaded;
    }

    /**
     * Check is loaded helper.
     *
     * @param   string $name   Helper key name.
     *
     * @return  bool
     */
    public function isLoaded(string $name): bool
    {
        return in_array(Str::lower($name), $this->loaded);
    }

    /**
     * Find and load helpers.
     *
     * @throws ReflectionException
     */
    public function loadHelpers(): void
    {
        $finder = new Finder();

        $finder
            ->files()
            ->followLinks()
            ->in(array_merge(
                [
                    app_path('Ship')
                ],
                Apiato::getAllContainerPaths()
            ))
            ->notName('/AppHelper\.php/')
            ->name('*' . self::HELPER_PREFIX . '.php');

        $this->addHelpers($finder);
    }

    /**
     * Add helpers.
     *
     * @param   Finder $finder
     *
     * @throws  ReflectionException
     */
    protected function addHelpers(Finder $finder): void
    {
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $className = Apiato::getClassFullNameFromFile($file->getPathname());
            $helperKeyName = self::getHelperKeyName($className);
            if (class_exists($className) && is_subclass_of($className, AppHelper::class)) {
                app()->bind(self::CONTAINER_NAME . '.' . $helperKeyName, $className);
                array_unshift($this->loaded, $helperKeyName);
            }
        }
    }
}
