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

namespace App\Containers\TelegramSection\Bot\Foundation;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use JBZoo\Data\JSON;

class Storage
{
    protected JSON $data;

    /**
     * @param string $namespace
     * @throws FileNotFoundException
     */
    public function __construct(
        protected string $namespace
    ) {
        $this->makeDirectory();
        $this->bind();
    }

    public function clear(mixed $without = []): bool
    {
        $without = (array)$without;

        $withoutValues = [];
        if (count($without)) {
            foreach ($without as $name) {
                $withoutValues[$name] = $this->get($name);
            }
        }

        $this->setClearData();

        $return = $this->clearFileContent(
            $this->getFilePath()
        );

        if (count($withoutValues)) {
            foreach ($withoutValues as $withoutName => $withoutValue) {
                $this->set($withoutName, $withoutValue);
            }
        }

        return $return;
    }

    public function delete(): bool
    {
        $this->setClearData();
        $filePath = $this->getFilePath(false);

        if (File::isFile($filePath)) {
            return File::delete($filePath);
        }

        return false;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data->find($key, $default);
    }

    public function getBasePath(): string
    {
        return storage_path('telegram/storage');
    }

    public function has(string $key): bool
    {
        return $this->data->has($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, mixed $value): self
    {
        $this->data = $this->data->set($key, $value);
        File::put($this->getFilePath(), $this->data->write());
        return $this;
    }

    protected function setClearData(): void
    {
        $this->data = new JSON();
    }

    protected function getFilePath(bool $clearContent = true): string
    {
        $filePath = $this->getBasePath() . '/' . $this->namespace . '.json';

        if (!File::isFile($filePath) && $clearContent) {
            $this->clearFileContent($filePath);
        }

        return $filePath;
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    private function bind(): void
    {
        $content = File::get($this->getFilePath());
        $this->data = new JSON($content);
    }

    private function clearFileContent(string $path): bool
    {
        return (bool)File::put($path, '{}');
    }

    private function makeDirectory(): void
    {
        $path = $this->getBasePath();

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 493, true);
        }
    }
}
