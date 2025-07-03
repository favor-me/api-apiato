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

namespace App\Containers\CommunitySection\OrganizationBranch\Dto;

use App\Ship\Dto\Dto;

class CreateOrganizationBranchDto extends Dto
{
    public ?string $latitude;
    public ?string $location;
    public ?string $longitude;
    public ?string $name;
    public ?string $organization_id;
    public ?string $phone_number;
    public ?string $responsible_by;
}
