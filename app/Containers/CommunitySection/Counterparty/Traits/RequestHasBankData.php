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

namespace App\Containers\CommunitySection\Counterparty\Traits;

use App\Containers\CommunitySection\Counterparty\Countries\Country;
use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Countries\RuCountry;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Models\Model;
use JBZoo\Data\JSON;
use ReflectionException;

/**
 * @property-read mixed $country
 * @property-read mixed $bank_data
 */
trait RequestHasBankData
{
    protected array $countryMessages = [];

    /**
     * @param array $rules
     * @return void
     * @throws ReflectionException
     */
    protected function getBankDataSchema(array &$rules): void
    {
        $country = $this->getCountry();
        if (!is_null($country)) {
            $schema = $country
                ->setOwnershipType(
                    $this->get($this->ownershipTypeKey())
                )
                ->getBankDataSchema(
                    $this->getBankData()
                );

            $rules = array_merge($rules, $schema->getRules());
            $this->countryMessages = $schema->getValidationMessages();
        }
    }

    protected function getBankData(): ?JSON
    {
        return null;
    }

    protected function getCountry(): ?Country
    {
        return Manager::getInstance()
            ->get(
                (string)$this->country
            );
    }

    protected function prepareForValidationCountry(): void
    {
        $country = $this->defaultCountry();
        $countryInput = $this->get($this->countryKey(), $country->getName());

        if (empty($countryInput)) {
            $countryInput = $country->getName();
        }

        $this->merge([
            $this->countryKey() => $countryInput
        ]);
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    protected function prepareForValidationBankData(): void
    {
        $model = $this->getFindBankDataModel();
        $hasBankDataInput = $this->has($this->bankDataKey());
        $bankDataInput = (array)$this->get($this->bankDataKey());

        if (!is_null($model) && count($bankDataInput) && $hasBankDataInput) {
            $bankData = array_replace(
                $model
                    ->getAttribute(
                        $this->bankDataKey()
                    )
                    ->getArrayCopy(),
                $bankDataInput
            );

            $this->merge([
                $this->bankDataKey() => $bankData
            ]);
        }
    }

    protected function getFindBankDataModel(): ?Model
    {
        return null;
    }

    protected function ownershipTypeKey(): string
    {
        return Counterparty::OWNERSHIP_TYPE;
    }

    protected function bankDataKey(): string
    {
        return Counterparty::BANK_DATA;
    }

    protected function countryKey(): string
    {
        return Counterparty::COUNTRY;
    }

    protected function defaultCountry(): Country
    {
        return Manager::getInstance()->get(RuCountry::class);
    }
}
