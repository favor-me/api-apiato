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

namespace App\Ship\Providers;

use ReflectionClass;
use ReflectionException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class DevelopmentLoaderProvider extends ServiceProvider
{
    protected const NAMESPACE = 'Development\\Commands\\';

    /**
     * @return void
     * @throws ReflectionException
     */
    public function boot(): void
    {
        $this
            ->loadConfig()
            ->loadLocals()
            ->loadConsoleCommands();
    }

    protected function loadConfig(): self
    {
        $gitConfig = $this->getBasePath('config/git.php');
        if (File::isFile($gitConfig)) {
            $this->mergeConfigFrom($gitConfig, 'dev.git');
        }

        $generatorConfig = $this->getBasePath('config/generator.php');
        if (File::isFile($generatorConfig)) {
            $this->mergeConfigFrom($generatorConfig, 'dev.generator');
        }

        return $this;
    }

    protected function loadConsoleCommands(): self
    {
        $directories = collect([
            $this->getBasePath('src/Commands'),
            $this->getBasePath('src/Generator/Commands'),
            $this->getBasePath('src/Nuxt/Generator/Commands')
        ]);

        $directories
            ->each(function ($path) {
                $this->loadConsoleCommandsByPath($path);
            });

        return $this;
    }

    protected function loadConsoleCommandsByPath(string $path): void
    {
        $ns = str_replace($this->getBasePath('src'), null, $path);
        $ns = trim(trim($ns, '/'), '\\');
        $ns = str_replace(['/', '\\'], '\\', $ns);

        if (File::isDirectory($path)) {
            $files = File::allFiles($path);

            foreach ($files as $consoleFile) {
                $commandClass = 'Development\\' . $ns . '\\' . $consoleFile->getFilenameWithoutExtension();
                $reflector = new ReflectionClass($commandClass);
                if ($reflector->isInstantiable()) {
                    $this->commands($commandClass);
                }
            }
        }
    }

    protected function loadLocals(): self
    {
        $directory = $this->getBasePath('lang');
        $this->loadTranslationsFrom($directory, 'development');
        return $this;
    }

    protected function getBasePath(?string $path): string
    {
        return base_path("development/{$path}");
    }
}
