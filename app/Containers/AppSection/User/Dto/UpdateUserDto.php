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

use App\Ship\Exceptions\UpdateResourceFailedException;

class UpdateUserDto extends RegisterUserDto
{
    public ?int $id;
    public ?bool $is_admin = null;
    public ?string $telegram_user_name = null;
    public array $params = [];

    /**
     * @throws UpdateResourceFailedException
     */
    public function checkCanDo(): void
    {
        if ($this->isEmpty() && count($this->profile) === 0) {
            throw new UpdateResourceFailedException(__('ship::exception.inputs_empty'));
        }
    }

    protected function setDefaultRole(): void
    {
        $this->role = null;
    }
}
