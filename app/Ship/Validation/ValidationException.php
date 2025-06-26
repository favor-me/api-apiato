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

namespace App\Ship\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException as BaseValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BaseValidationException
{
    /**
     * @param Validator $validator
     * @param Response|null $response
     * @param string $errorBag
     */
    public function __construct($validator, $response = null, $errorBag = 'default')
    {
        $this->response = $response;
        $this->errorBag = $errorBag;
        $this->validator = $validator;
        $this->message = __('ship::exception.given_data_was_invalid');
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}
