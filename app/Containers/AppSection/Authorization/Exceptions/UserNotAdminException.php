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

namespace App\Containers\AppSection\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserNotAdminException
 *
 * @package App\Containers\AppSection\Authorization\Exceptions
 */
class UserNotAdminException extends Exception
{
    protected $code = Response::HTTP_FORBIDDEN;
    protected $message = 'This User does not have an Admin permission.';
}
