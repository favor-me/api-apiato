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

namespace App\Containers\CommunitySection\Organization\Dto;

use App\Ship\Dto\Dto;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class CreateOrganizationDto extends Dto
{
    public ?string $email;
    public string $country = 'ru';
    public ?string $name;
    public ?array $params = [];
    public array $bank_data = [];
    public ?int $phone_number;
    public ?int $user_owner_id;
}
