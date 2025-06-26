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

namespace App\Ship\Requests;

use Apiato\Core\Abstracts\Requests\Request as AbstractRequest;
use App\Ship\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

abstract class FormRequest extends AbstractRequest
{
    public const CHECKBOX_CHECKED_VALUE = 'on';

    protected array $access = [
        'permissions' => null,
        'roles' => null
    ];

    protected array $checkboxInputs = [];

    protected array $decode = [];

    protected string $flashKey = FLASH_ERROR;

    protected array $urlParameters = [];

    public function authorize(): bool
    {
        return true;
    }

    protected function checkboxIsCheckedValue(string $inputKey): bool
    {
        return $this->get($inputKey) === self::CHECKBOX_CHECKED_VALUE;
    }

    protected function failedValidation(Validator $validator): void
    {
        $exception = new ValidationException($validator);

        $this->session()->flash($this->flashKey, $exception->getMessage());

        throw $exception
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    protected function prepareForValidation()
    {
        $this->prepareForValidationCheckboxInputs();
    }

    protected function prepareForValidationCheckboxInputs(): self
    {
        if (count($this->checkboxInputs)) {
            foreach ($this->checkboxInputs as $checkboxInput) {
                $this->merge([
                    $checkboxInput => $this->checkboxIsCheckedValue($checkboxInput) ? PUBLISHED : UNPUBLISHED
                ]);
            }
        }

        return $this;
    }
}
