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
 * Class NotImplementedException
 *
 * @package App\Ship\Exceptions
 */
class NotImplementedException extends Exception
{
    protected $code = Response::HTTP_NOT_IMPLEMENTED;
    protected $message = 'This method is not yet implemented.';
}
