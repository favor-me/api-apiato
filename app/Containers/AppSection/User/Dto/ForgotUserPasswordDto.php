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

class ForgotUserPasswordDto extends Dto
{
    public string $email;
    public ?string $resetUrl;

    /**
     * @inheritDoc
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        if (array_key_exists('reset_url', $this->args)) {
            $this->resetUrl = $this->args['reset_url'];
        }
    }
}
