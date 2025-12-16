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

namespace App\Containers\CommunitySection\Counterparty\Dto;

use App\Ship\Dto\Dto;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CreateCounterpartyDto extends Dto
{
    public ?string $legal_address;
    public ?string $mailing_address;
    public ?array $bank_data = [];
    public ?string $country;
    public ?string $email;
    public ?string $name;
    public ?string $ownership_type;
    public ?string $organization_id;
    public ?string $phone_number;
}
