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

namespace App\Ship\Parents\Exceptions;

use Apiato\Core\Abstracts\Exceptions\Exception as AbstractException;
use Throwable;

abstract class Exception extends AbstractException
{
    public function __construct(?string $message = null, ?int $code = null, ?Throwable $previous = null)
    {
        if (app('translator')->has($this->message)) {
            $this->message = trans($this->message);
        }

        parent::__construct($message, $code, $previous);
    }
}
