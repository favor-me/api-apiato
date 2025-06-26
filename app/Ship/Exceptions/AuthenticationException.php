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
 * Class AuthenticationException
 *
 * @package App\Ship\Exceptions
 */
class AuthenticationException extends Exception
{
    protected $code = RESPONSE::HTTP_UNAUTHORIZED;
    protected $message = 'An Exception occurred when trying to authenticate the User.';
}
