<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelEvent\Exceptions;

use App\Containers\HistorySection\ModelEvent\Facades\Container;
use App\Ship\Exceptions\NotFoundException;
use Exception as BaseException;

final class NotFoundModelEventTypeException extends NotFoundException
{
    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        if (is_null($message)) {
            $this->message = Container::trans('exception.event_type_no_found');
        }

        parent::__construct($message, $code, $previous);
    }
}
