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

namespace App\Ship\SimpleTypes\Config;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Dto\CurrencyDto;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Ship\Parents\SimpleTypes\Config\Config as ShipConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JBZoo\SimpleTypes\Formatter;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Money extends ShipConfig
{
    public const CURRENCY = 'currency';
    public const EXCHANGE = 'exchange';

    public function __construct()
    {
        $this->default = self::EXCHANGE;
        $this->setDefaultParams();
    }

    public function getRules(): array
    {
        return [
            self::CURRENCY => [
                'rate' => 100,
                'decimal_sep' => ',',
                'symbol' => $this->getCurrencySymbol()
            ],
            self::EXCHANGE => [
                'rate' => 1,
                'num_decimals' => 0,
                'symbol' => $this->getExchangeSymbol()
            ],
            '%' => [
                'symbol' => '%',
                'format_positive' => '%v%s',
                'format_negative' => '-%v%s',
            ]
        ];
    }

    /**
     * @return Collection
     * @throws UnknownProperties
     */
    public static function getAllowedCurrencies(): Collection
    {
        $currencies = collect();
        foreach (config('money.currencies') as $code => $data) {
            $currencies->add(new CurrencyDto(array_merge($data, [
                'title' => __('ship::money.' . $code . '.title'),
                'code' => $code
            ])));
        }

        return $currencies;
    }

    protected function setDefaultParams(): void
    {
        $this->defaultParams = array_merge($this->defaultParams, [
            'format_positive' => '%v %s',
            'format_negative' => '-%v %s',
            'round_type' => Formatter::ROUND_CLASSIC,
            'decimal_sep' => config('money.decimal_sep'),
            'num_decimals' => $this->getNumDecimals(),
            'thousands_sep' => config('money.thousands_sep')
        ]);
    }

    protected function getNumDecimals(): mixed
    {
        return config('money.num_decimals');
    }

    public function getCurrencySymbol(): string
    {
        $defaultCurrency = $this->getDefaultUserCurrency();
        return config('money.currencies.' . $defaultCurrency . '.' . self::CURRENCY);
    }

    public function getExchangeSymbol(): string
    {
        $defaultCurrency = $this->getDefaultUserCurrency();
        return config('money.currencies.' . $defaultCurrency . '.' . self::EXCHANGE);
    }

    protected function getDefaultUserCurrency(): string
    {
        $defaultCurrency = config('money.default_currency');

        $authUser = Auth::user();
        if ($authUser instanceof User) {
            $userCustomCurrency = $authUser->params->get(BaseUser::PARAM_CURRENCY, $defaultCurrency);
            if (!empty($userCustomCurrency)) {
                $defaultCurrency = $userCustomCurrency;
            }
        }

        return $defaultCurrency;
    }
}
