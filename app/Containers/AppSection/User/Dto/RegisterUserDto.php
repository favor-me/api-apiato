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

use App\Ship\Dto\Dto;
use Illuminate\Support\Facades\Hash;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class RegisterUserDto extends Dto
{
    public ?string $name;
    public ?string $login;
    public ?string $patronymic;
    public ?string $surname;
    public ?bool $gender;
    public ?string $birth;
    public ?string $avatar;
    public ?string $email;
    public ?string $phone_number;
    public ?string $password;
    public ?bool $is_admin = false;
    public ?bool $is_organization_owner = false;
    public ?int $organization_id = null;
    public ?int $organization_branch_id = null;
    public ?string $role;

    /**
     * @inheritDoc
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);
        $this->setDefaultRole();
    }

    public function hashPassword(): self
    {
        if (!empty($this->password)) {
            $this->password = Hash::make($this->password);
        }

        return $this;
    }

    protected function setDefaultRole(): void
    {
        if (is_null($this->role)) {
            $this->role = config('appSection-user.registration.default-role');
        }
    }

    public function getData(): array
    {
        return $this
            ->except('id', 'role')
            ->toArray(true);
    }

    public function isEmpty(): bool
    {
        return !count($this->getData());
    }
}
