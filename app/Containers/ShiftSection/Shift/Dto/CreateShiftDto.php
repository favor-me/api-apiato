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

namespace App\Containers\ShiftSection\Shift\Dto;

use App\Ship\Dto\Dto;

class CreateShiftDto extends Dto
{
    public ?int $created_by;
    public ?int $confirmed_by;
    public bool $confirmed = false;
    public bool $payment = false;
    public ?string $finish_at;
    public ?int $organization_id;
    public ?int $organization_branch_id;
    public ?string $start_at;
}
