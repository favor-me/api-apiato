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

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserNotConfirmedException
 *
 * @package App\Containers\AppSection\Authentication\Exceptions
 */
class UserNotConfirmedException extends Exception
{
    protected $code = Response::HTTP_CONFLICT;
    protected $message = 'The user email is not confirmed yet. Please verify your user before trying to login.';
}
