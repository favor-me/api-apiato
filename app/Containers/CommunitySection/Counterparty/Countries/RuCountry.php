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

use App\Containers\CommunitySection\Counterparty\Countries\BankData\Element;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\BankElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\BikElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\CorrespondentAccountElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\InnElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\KppElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\OkatoElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\OkpoElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\OkvedElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\OrgnipElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\PaymentAccountElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Schema;
use JBZoo\Data\JSON;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RuCountry extends Country
{
    public function getBankDataSchema(?JSON $data = null): Schema
    {
        $schema = new Schema();

        return $schema
            ->addElement(
                new InnElement($data)
            )
            ->addElement(
                new KppElement($data)
            )
            ->addElement(
                new OrgnipElement($data)
            )
            ->addElement(
                new PaymentAccountElement($data)
            )
            ->addElement(
                new BankElement($data)
            )
            ->addElement(
                new CorrespondentAccountElement($data)
            )
            ->addElement(
                new BikElement($data)
            )
            ->addElement(
                new OkpoElement($data)
            )
            ->addElement(
                new OkvedElement($data)
            )
            ->addElement(
                new OkatoElement($data)
            );
    }

    public function getUniqueElement(): Element
    {
        return new InnElement();
    }
}
