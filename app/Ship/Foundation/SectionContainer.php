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

namespace App\Ship\Foundation;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class SectionContainer
{
    public const SECTION_POSTFIX = 'Section';
    public const VENDOR_SECTION = 'Vendor';

    protected const CONFIG_NAME_SEPARATOR = '-';
    protected const TRANSLATOR_NAME_SEPARATOR = '@';
    protected const TRANSLATOR_NS_SEPARATOR = '::';

    protected string $apiBaseUri;

    protected ?string $configName = null;
    protected string $gender = 'male';

    protected string $transMultipleItemsKey = 'container.items';

    private Collection $classDetails;

    private string $name;

    private string $sectionName;

    public function __construct()
    {
        $this->classDetails = collect(explode('\\', static::class));
        $this->name = $this->classDetails->last();
        $this->setSectionName();
        $this->setConfigName();
    }

    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUri;
    }

    public function getApiUri(?string $uri = null): string
    {
        $apiUri = $this->apiBaseUri;

        if (!is_null($uri)) {
            $apiUri .= '/' . $uri;
        }

        return $apiUri;
    }

    public function getConfig(?string $key = null, $default = null): mixed
    {
        $configName = $this->getConfigName();

        if (is_null($key)) {
            return config($configName);
        }

        return config(implode('.', [
            $configName,
            $key
        ]), $default);
    }

    public function getConfigName(): ?string
    {
        return $this->configName;
    }

    public function getName(bool $lcFirst = false): string
    {
        return $lcFirst === true ? lcfirst($this->name) : $this->name;
    }

    public function getPath(?string $path = null): string
    {
        $fullPath = [
            'Containers',
            $this->getSectionName(),
            $this->getName(),
            $path
        ];

        return app_path(implode(DIRECTORY_SEPARATOR, $fullPath));
    }

    public function getSectionName(bool $lcFirst = false): string
    {
        return $lcFirst === true ? lcfirst($this->sectionName) : $this->sectionName;
    }

    public function trans(
        ?string $key = null,
        array $replace = [],
        ?string $locale = null
    ): array|Application|Translator|string|null {
        return __($this->transFullKey($key), $replace, $locale);
    }

    public function transFullKey(?string $key = null): string
    {
        return implode(self::TRANSLATOR_NS_SEPARATOR, [
            $this->getBaseTranslatorNamespace(),
            $key
        ]);
    }

    public function transMultipleDeleted(int $count): string
    {
        return trans_choice('action.deleted_multiple', $count, [
            'deletes' => $this->transLowerChoice('core.' . $this->gender . '_deletes', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }

    public function transMultipleRestored(int $count): string
    {
        return trans_choice('action.restored_multiple', $count, [
            'restores' => $this->transLowerChoice('core.' . $this->gender . '_restored', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }

    public function transMultipleTrashed(int $count): string
    {
        return trans_choice('action.trashed_multiple', $count, [
            'moved' => $this->transLowerChoice('core.' . $this->gender . '_moved', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }

    public function transMultipleUpdated(int $count): string
    {
        return trans_choice('action.updated_multiple', $count, [
            'updates' => $this->transLowerChoice('core.' . $this->gender . '_updates', $count),
            'items' => $this->transLowerChoice($this->getTransMultipleItemsKey(), $count)
        ]);
    }

    private function transLowerChoice(string $key, int $count): string
    {
        return Str::lower(trans_choice($key, $count));
    }

    protected function getTransMultipleItemsKey(): string
    {
        return $this->getBaseTranslatorNamespace() . self::TRANSLATOR_NS_SEPARATOR . $this->transMultipleItemsKey;
    }

    public function getBaseTranslatorNamespace(): string
    {
        return $this->primitiveNamespace(self::TRANSLATOR_NAME_SEPARATOR);
    }

    protected function primitiveNamespace(
        ?string $separator = self::CONFIG_NAME_SEPARATOR,
        bool $lcFirst = true
    ): string {
        return implode($separator, [
            $this->getSectionName($lcFirst),
            $this->getName($lcFirst)
        ]);
    }

    protected function setConfigName(): void
    {
        if (is_null($this->configName)) {
            $this->configName = $this->primitiveNamespace();
        }
    }

    private function setSectionName(): void
    {
        $this->sectionName = $this->classDetails
            ->first(function ($detail, $key) {
                if ($key === 2 && $detail === self::VENDOR_SECTION) {
                    return self::VENDOR_SECTION;
                }

                return str_ends_with($detail, self::SECTION_POSTFIX) === true;
            });
    }
}
