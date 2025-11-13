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

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use Illuminate\Contracts\Support\Arrayable;
use JBZoo\Data\JSON;

class Schema implements Arrayable
{
    protected Collection $elements;

    public function __construct()
    {
        $this->elements = new Collection();
    }

    public function addElement(Element $element): self
    {
        $this->elements->add($element);
        return $this;
    }

    public function getRules(): array
    {
        $rules = [];
        /** @var Element $element */
        foreach ($this->elements->getElements() as $element) {
            $rules[Counterparty::BANK_DATA . '.' . $element->getName()] = $element->getRules();
        }

        return $rules;
    }

    public function getValidationMessages(): array
    {
        $messages = [];
        /** @var Element $element */
        foreach ($this->elements->getElements() as $element) {
            $messages += $element->getValidationMessages();
        }

        return $messages;
    }

    public function toJson(): string
    {
        return (new JSON(
            $this->elements->getElements()
        ))
            ->write();
    }

    public function toSchema(): array
    {
        $schema = [];
        /** @var Element $element */
        foreach ($this->elements->getElements() as $element) {
            $schema[] = $element->toArray();
        }

        return $schema;
    }

    public function toArray(): array
    {
        return $this->elements->getElements();
    }
}
