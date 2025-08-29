<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\Exceptions;

use App\Containers\AppSection\User\Facades\Container;
use App\Ship\Parents\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class UserIsNotOrganizationOwnerException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        if (!config('app.debug')) {
            $message = $code = null;
        }

        if (is_null($message)) {
            $this->message = Container::trans('user.user_is_not_organization_owner');
        }

        parent::__construct($message, $code, $previous);
    }
}
