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

namespace App\Ship\SimpleTypes\Type;

use App\Ship\Parents\SimpleTypes\Type\Type;
use App\Ship\SimpleTypes\Config\Money as MoneyConfig;
use JBZoo\SimpleTypes\Config\AbstractConfig;
use JBZoo\SimpleTypes\Type\AbstractType;

class Money extends Type
{
    public function __construct($value = null, ?AbstractConfig $config = null)
    {
        if (is_null($config)) {
            $config = new MoneyConfig();
        }

        parent::__construct($value, $config);
    }

    public function currency(): AbstractType
    {
        return $this->convert(MoneyConfig::CURRENCY, true);
    }

    public function addCurrency($value, bool $getClone = false): self
    {
        return parent::add($value . ' ' . MoneyConfig::CURRENCY, $getClone);
    }

    public function getSymbol(): string
    {
        return $this->formatter->get($this->internalRule)['symbol'];
    }

    public function getTransformerData(): array
    {
        $ruleParams = $this->formatter->get($this->rule);

        $value = $this->val();
        if ($this->rule === MoneyConfig::EXCHANGE) {
            $value = (int) $value;
        }

        return [
            'value' => $value,
            'symbol' => $ruleParams['symbol'],
            'text' => $this->text(),
            'no_style' => $this->noStyle(),
            'rule' => $this->getRule()
        ];
    }
}
