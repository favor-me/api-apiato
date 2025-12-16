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

namespace App\Containers\CommunitySection\Counterparty\UI\API\Transformers;

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Primitive;
use ReflectionException;

class CounterpartyTransformer extends Transformer
{
    protected array $defaultIncludes = [
        Counterparty::BANK_DATA_SCHEMA
    ];

    public function transform(CounterpartyModel $counterparty): array
    {
        return [
            OBJECT => $counterparty->getResourceKey(),
            ID => $counterparty->getHashedKey(),
            CounterpartyModel::NUMBER => $counterparty->getNumber(),
            Counterparty::NAME => $counterparty->name,
            Counterparty::OWNERSHIP_TYPE => $this->getOwnershipType($counterparty),
            Counterparty::LEGAL_ADDRESS => $counterparty->legal_address,
            Counterparty::MAILING_ADDRESS => $counterparty->mailing_address,
            Counterparty::PHONE_NUMBER => $counterparty->phone_number,
            Counterparty::EMAIL => $counterparty->email,
            Counterparty::COUNTRY => $counterparty->country->toArray(),
            Counterparty::BANK_DATA => $counterparty->bank_data,
            Counterparty::ORGANIZATION_ID => $counterparty->getHashedKey(Counterparty::ORGANIZATION_ID),
            CREATED_AT => $this->time($counterparty->created_at),
            UPDATED_AT => $this->time($counterparty->updated_at),
            DELETED_AT => $this->time($counterparty->deleted_at)
        ];
    }

    /**
     * @param CounterpartyModel $counterparty
     * @return Primitive
     * @throws ReflectionException
     */
    protected function includeBankDataSchema(CounterpartyModel $counterparty): Primitive
    {
        return $this->primitive(
            $counterparty->country
                ->setOwnershipType($counterparty->ownership_type)
                ->getBankDataSchema($counterparty->bank_data)
                ->toSchema()
        );
    }

    private function getOwnershipType(CounterpartyModel $counterparty): ?array
    {
        return !is_null($counterparty->ownership_type) ? $counterparty->ownership_type->toArray() : null;
    }
}
