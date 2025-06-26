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

namespace App\Containers\AppSection\User\Dto;

class UpdateUserDto extends RegisterUserDto
{
    public ?int $id;
    public ?bool $is_admin = null;
    public array $params = [];

    protected function setDefaultRole(): void
    {
        $this->role = null;
    }
}
