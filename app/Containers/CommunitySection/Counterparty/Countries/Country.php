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

use App\Containers\CommunitySection\Counterparty\Countries\BankData\Schema;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Ship\Contracts\Namebled;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use JBZoo\Data\JSON;
use ReflectionClass;

abstract class Country implements Namebled, Arrayable
{
    abstract public function getBankDataSchema(?JSON $data = null): Schema;

    abstract public function getUniqueElement(): string;

    public function getName(): string
    {
        $reflectionType = new ReflectionClass(static::class);
        $name = str_replace('Country', '', $reflectionType->getShortName());
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
}
