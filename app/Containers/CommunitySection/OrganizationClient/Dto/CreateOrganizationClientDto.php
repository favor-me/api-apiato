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

namespace App\Containers\CommunitySection\OrganizationClient\Dto;

use App\Ship\Dto\Dto;

class CreateOrganizationClientDto extends Dto
{
    public ?string $name;
    public ?string $note;
    public ?string $organization_id;
    public ?string $patronymic;
    public ?string $phone_number;
    public ?string $surname;
}
