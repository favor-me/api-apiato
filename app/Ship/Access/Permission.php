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

namespace App\Ship\Access;

use App\Containers\AppSection\Authorization\Dto\CreatePermissionDto;
use App\Ship\Contracts\ListableCollection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class Permission implements ListableCollection
{
    public function getLangNamespace(): string
    {
        return lcfirst($this->getSection()) . '@' . lcfirst($this->getContainer()) . '::permission';
    }

    abstract public function getSection(): string;

    abstract public function getContainer(): string;

    public function getTranslateKey(string $key): string
    {
        return $this->getLangNamespace() . ".{$key}";
    }

    public function trans(string $key): string
    {
        return (string)__($this->getTranslateKey($key));
    }

    /**
     * @param string $name
     * @param array $data
     * @return CreatePermissionDto
     * @throws UnknownProperties
     */
    public function createPermissionDto(string $name, array $data = []): CreatePermissionDto
    {
        $data = collect($data);

        $data->put('name', $name);

        if (!$data->has('section')) {
            $data->put('section', $this->getSection());
        }

        if (!$data->has('container')) {
            $data->put('container', $this->getContainer());
        }

        $details = explode('\\', static::class);
        $shortClassName = array_pop($details);
        $permissionName = str_replace('Permissions', null, $shortClassName);
        $kebabPermissionName = Str::kebab($permissionName);
        $sectionName = Str::kebab($this->getSection());
        $translateKey = trim(str_replace([$kebabPermissionName, $sectionName], null, $name), '-');
        $translateKey = Str::slug(trim($translateKey, '_'), '_');

        if (!$data->has('display_name')) {
            $data->put('display_name', $this->getTranslateKey($translateKey . '.name'));
        }

        if (!$data->has('description')) {
            $data->put('description', $this->getTranslateKey($translateKey . '.description'));
        }

        return new CreatePermissionDto($data->toArray());
    }
}
