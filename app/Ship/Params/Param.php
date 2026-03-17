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

namespace App\Ship\Params;

use App\Ship\Collections\ValidationRules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use JBZoo\Data\JSON;

abstract class Param
{
    protected string $type;
    protected string $name;
    protected string $cacheKey;

    public function __construct(
        protected Model $model
    ) {
        $this->cacheKey = $this->getCacheKey();
        $this->init();
    }

    public function get(): array
    {
        return [
            'name' => $this->name,
            'title' => $this->getTitle(),
            'hint' => $this->getHint(),
            'type' => $this->type,
            'value' => $this->getValue(),
            'rules' => $this->getValidationRules()
        ];
    }

    public function getValue(): mixed
    {
        $param = $this->model->getAttribute(PARAMS);
        return $param instanceof JSON ? $param->get($this->name) : null;
    }

    public static function getValidationRules(): ValidationRules
    {
        return validation_rules();
    }

    protected function getTitle(): string
    {
        return 'container.params.' . $this->name . '.title';
    }

    protected function getHint(): string
    {
        return 'container.params.' . $this->name . '.hint';
    }

    protected function init(): void
    {
    }

    protected function getCacheKey(): string
    {
        return $this->toKey(static::class);
    }

    protected function toKey(string $value): string
    {
        return Str::slug(Str::kebab($value));
    }
}
