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

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        if (!config('app.debug')) {
            $message = $code = null;
        }

        if (is_null($message)) {
            $this->message = __('ship::exception.no_found_resource');
        }

        parent::__construct($message, $code, $previous);
    }
}
