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

namespace App\Containers\CommunitySection\Counterparty\Countries\BankData;

use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use JBZoo\Data\JSON;
use JsonSerializable;

abstract class Element implements JsonSerializable
{
    public const string TYPE_INT = 'int';
    public const string TYPE_STRING = 'string';

    protected string $type;
    protected string $country = 'rus';
    protected string $name;
    protected string $title;
    protected mixed $value = null;
    protected array $rules = [];
    protected JSON|null $data = null;

    public function __construct(JSON $data = null)
    {
        $this->data = $data;
        $this->title = $this->trans('title');
    }

    public function trans(?string $key = null, array $replace = []): mixed
    {
        return Container::trans(implode('.', [
            $this->country,
            $this->name,
            $key
        ]), $replace);
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toJson(): string
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'title' => $this->title,
            'value' => $this->value
        ];
    }

    public function getValidationMessages(): array
    {
        return [];
    }

    protected function validationRuleName(string $rule): string
    {
        return Counterparty::BANK_DATA . '.' . $this->name . '.' . $rule;
    }
}
