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

use Exception as BaseException;
use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InternalErrorException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        if (!config('app.debug')) {
            $message = $code = null;
        }

        if (is_null($message)) {
            $this->message = __('ship::exception.something_went_wrong');
        }

        parent::__construct($message, $code, $previous);
    }
}
