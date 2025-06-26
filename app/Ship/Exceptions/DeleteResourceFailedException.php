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

/**
 * Class DeleteResourceFailedException
 *
 * @package App\Ship\Exceptions
 */
class DeleteResourceFailedException extends Exception
{
    /**
     * Hold response code.
     *
     * @var int
     */
    protected $code = Response::HTTP_EXPECTATION_FAILED;

    /**
     * DeleteResourceFailedException constructor.
     *
     * @param   string|null $message
     * @param   int|null $code
     * @param   BaseException|null $previous
     */
    public function __construct(?string $message = null, ?int $code = null, ?BaseException $previous = null)
    {
        if (!config('app.debug')) {
            $message = $code = null;
        }

        if (is_null($message)) {
            $this->message = __('ship::exception.failed_delete_resource');
        }

        parent::__construct($message, $code, $previous);
    }
}
