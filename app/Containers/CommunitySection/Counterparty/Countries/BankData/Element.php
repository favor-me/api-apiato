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

use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Countries\Manager as CountryManager;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\OrganizationSection\OwnershipType\Manager as OwnershipTypeManager;
use App\Containers\OrganizationSection\OwnershipType\Type as OwnershipType;
use App\Ship\Collections\ValidationRules;
use Illuminate\Contracts\Support\Arrayable;
use JBZoo\Data\JSON;
use JsonSerializable;

abstract class Element implements JsonSerializable, Arrayable
{
    public const string TYPE_INT = 'int';
    public const string TYPE_STRING = 'string';

    protected int $ordering = 0;
    protected string $type;
    protected Country $country;
    protected string $name;
    protected string $title;
    protected mixed $value = null;
    protected array $rules = [];
    protected JSON|null $data = null;
    protected ?OwnershipType $ownershipType = null;

    public function __construct(JSON $data = null, ?string $ownershipType = null)
    {
        $this->data = $data;

        if (!is_null($ownershipType)) {
            $this->ownershipType = OwnershipTypeManager::getInstance()->get($ownershipType);
        }

        $this
            ->setCountry()
            ->bindValue();

        $this->title = $this->trans('title');
    }

    public function getOrdering(): int
    {
        return $this->ordering;
    }

    public function trans(?string $key = null, array $replace = []): mixed
    {
        return Container::trans(implode('.', [
            $this->country->getName(),
            $this->name,
            $key
        ]), $replace);
    }

    public function getRules(): array
    {
        if ($this->canRemoveRequiredValidationRule()) {
            unset($this->rules[array_search(ValidationRules::REQUIRED, $this->rules)]);
        }

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
            'value' => $this->value,
            'rules' => $this->apiRules()
        ];
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    public function apiRules(): array
    {
        return array_filter($this->rules, fn ($rule) => is_string($rule));
    }

    public function getValidationMessages(): array
    {
        return [];
    }

    public function canAddToSchema(): bool
    {
        if ($this->hasOwnershipType()) {
            return in_array(
                $this->ownershipType->getName(),
                $this->forOwnershipTypes()
            );
        }

        return false;
    }

    public function forOwnershipTypes(): array
    {
        return [];
    }

    protected function canRemoveRequiredValidationRule(): bool
    {
        return in_array(ValidationRules::REQUIRED, $this->rules) && !is_null($this->value);
    }

    protected function hasOwnershipType(): bool
    {
        return $this->ownershipType !== null;
    }

    protected function setCountry(): static
    {
        $this->country = CountryManager::getInstance()
            ->get(
                $this->getCountryAccessor()
            );

        return $this;
    }

    protected function getCountryAccessor(): string
    {
        return RuCountry::class;
    }

    protected function validationRuleName(string $rule): string
    {
        return Counterparty::BANK_DATA . '.' . $this->name . '.' . $rule;
    }

    protected function bindValue(): void
    {
        if (!is_null($this->data)) {
            $this->value = $this->data->get($this->name);
        }
    }
}
