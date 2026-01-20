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

namespace App\Containers\CommunitySection\Counterparty\Countries;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Element;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Schema;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Ship\Contracts\Namebled;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JBZoo\Data\JSON;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

abstract class Country implements Namebled, Arrayable
{
    protected ?string $ownershipType = null;
    protected ?int $ignoreValue = null;

    /**
     * @param JSON|null $data
     * @return Schema
     * @throws ReflectionException
     */
    public function getBankDataSchema(?JSON $data = null): Schema
    {
        $schema = new Schema();

        $this
            ->getAllElements($data)
            ->each(function (Element $element) use (&$schema) {
                if ($element->canAddToSchema()) {
                    $schema->addElement($element);
                }
            });

        return $schema;
    }

    abstract public function getUniqueElement(): Element;

    public function setOwnershipType(?string $ownershipType): static
    {
        $this->ownershipType = $ownershipType;
        return $this;
    }

    public function setIgnoreValue(?int $ignoreValue): static
    {
        $this->ignoreValue = $ignoreValue;
        return $this;
    }

    public function getIgnoreValue(): ?int
    {
        return $this->ignoreValue;
    }

    public function getName(): string
    {
        $reflectionType = new ReflectionClass(static::class);
        $name = str_replace(Manager::PREFIX, '', $reflectionType->getShortName());
        return Str::snake($name);
    }

    public function getTitle(): string
    {
        return (string)Container::trans($this->getName() . '.title');
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'name' => $this->getName()
        ];
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @param JSON|null $data
     * @return Collection
     * @throws ReflectionException
     */
    public function getAllElements(?JSON $data = null): Collection
    {
        $elementsPath = Container::getPath('Countries/BankData/' . Str::ucfirst($this->getName()));

        $finder = new Finder();

        $files = $finder
            ->files()
            ->followLinks()
            ->in($elementsPath);

        $elements = collect();

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $className = Apiato::getClassFullNameFromFile($file->getPathname());
            $elementClass = new ReflectionClass($className);
            if ($elementClass->isInstantiable() && $elementClass->isSubclassOf(Element::class)) {
                $element = new $className($data, $this->ownershipType);
                $elements->add($element);
            }
        }

        return $elements
            ->sortByDesc(
                fn (Element $element) => $element->getOrdering()
            );
    }
}
