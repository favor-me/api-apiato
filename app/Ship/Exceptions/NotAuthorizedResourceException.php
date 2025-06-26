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
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotAuthorizedResourceException
 *
 * @package App\Ship\Exceptions
 */
class NotAuthorizedResourceException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'You are not authorized to request this resource.';
}
