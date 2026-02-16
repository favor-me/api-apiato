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

namespace App\Ship\Exceptions;

use Exception as BaseException;
use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class MissingTimeZoneHeaderException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;

    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        $this->message = __('ship::exception.missing_time_zone_header');
        parent::__construct($message, $code, $previous);
    }
}
