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

namespace App\Ship\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class ToListTransformer extends Transformer
{
    public function __construct(
        protected bool $useHashedValue = true
    ) {
    }

    abstract public function getDefaultTitle(Model $model): mixed;

    public function getDefaultValue(Model $model): mixed
    {
        return $this->getHashedKeyOrValue($model);
    }

    /**
     * @param Model $model
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTitle(Model $model): mixed
    {
        return $this->getReplaceValue($model, ApiRequest::TITLE_AS, true);
    }

    /**
     * @param Model $model
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getValue(Model $model): mixed
    {
        return $this->getReplaceValue($model, ApiRequest::VALUE_AS);
    }

    /**
     * @param Model $model
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function transform(Model $model): array
    {
        return [
            'value' => $this->getValue($model),
            'title' => $this->getTitle($model)
        ];
    }

    protected function getHashedKeys(): Collection
    {
        return collect([ID]);
    }

    /**
     * @param Model $model
     * @param string $requestKeyName
     * @param bool $isTitle
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getReplaceValue(Model $model, string $requestKeyName, bool $isTitle = false): mixed
    {
        $requestKey = request()->get($requestKeyName);
        $attributes = $model->getAttributes();

        if ($requestKey !== null) {
            if (in_array($requestKey, $this->getHashedKeys()->toArray())) {
                return $this->getHashedKeyOrValue($model, $requestKey);
            }

            return Arr::get($attributes, $requestKey);
        }

        return $isTitle ? $this->getDefaultTitle($model) : $this->getDefaultValue($model);
    }

    protected function getHashedKeyOrValue(Model $model, string $attributeKey = ID): mixed
    {
        if ($this->useHashedValue && method_exists($model, 'getHashedKey')) {
            return $model->getHashedKey();
        }

        return $model->getAttribute($attributeKey);
    }
}
