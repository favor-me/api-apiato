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

use App\Containers\CommunitySection\Counterparty\Countries\BankData\IntElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\BankElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\BikElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\CorrespondentAccountElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\InnElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\KppElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\OkatoElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\OkpoElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\OkvedElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\OrgnipElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus\PaymentAccountElement;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Schema;
use JBZoo\Data\JSON;

class RusCountry extends Country
{
    public const string INN = 'inn';

    public function getBankDataSchema(JSON $data = null): Schema
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
}
