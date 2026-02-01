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

use App\Containers\AppSection\User\Models\User;
use App\Ship\Dto\Dto;

class ResetUserPasswordDto extends Dto
{
    public string $value;
    public string $token;
    public string $password;
    public ?string $password_confirmation;

    /**
     * @inheritDoc
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->setPassportConfirmation();
    }

    public function toCredentials(): array
    {
        $data = $this
            ->except('value', 'password_confirmation')
            ->toArray();

        $data[(new User())->getColumnNameForPasswordReset()] = $this->value;

        return $data;
    }

    protected function setPassportConfirmation(): self
    {
        $this->password_confirmation = $this->password;
        return $this;
    }
}
