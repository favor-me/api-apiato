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

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Validation\Rule;
use App\Ship\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rules\Exists;

abstract class ApiRequest extends Request
{
    public const TITLE_AS = 'title-as';
    public const VALUE_AS = 'value-as';
    public const TO_LIST_VALUE = 'list';

    protected array $access = [
        'permissions' => '',
        'roles' => ''
    ];

    protected array $decode = [];

    protected array $urlParameters = [];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess'
        ]);
    }

    public function takeWithTrashed(): bool
    {
        return $this->get('take') === 'with-trashed';
    }

    public function takeOnlyTrashed(): bool
    {
        return $this->get('take') === 'only-trashed';
    }

    public function isToList(): bool
    {
        return $this->get('to') === self::TO_LIST_VALUE;
    }

    public function isAdminUser(): bool
    {
        return !is_null($this->user()) && $this->user()->is_admin === true;
    }

    public function getLimit(): mixed
    {
        return $this->get('limit');
    }

    public function decode(string|null $id): int|null
    {
        $result = parent::decode($id);

        if (is_array($result) && count($result) === ZERO) {
            return null;
        }

        return $result;
    }

    public function existsWithCreatedByRule($table, User $user, $ids, ?string $errorMessage = null): Exists
    {
        $ids = (array)$ids;
        if (empty($errorMessage)) {
            $errorMessage = __('validation.custom.ids.exists');
        }

        return Rule::exists($table, 'id')
            ->where(function (Builder $query) use ($user, $ids, $errorMessage) {
                if (!$user->is_admin) {
                    $query->where('created_by', $user->id);
                }

                $query->whereIn('id', $ids);

                if ($query->count() > 0 && count($ids) !== $query->count()) {
                    $this->validator->setCustomMessages([
                        'ids.exists' => $errorMessage
                    ]);
                }

                return $query;
            });
    }

    public function rules(): array
    {
        return [];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('ship::exception.unauthorized_action'));
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }

    protected function mergeDecode($values): self
    {
        $this->decode = array_merge($this->decode, (array) $values);
        return $this;
    }

    protected function mergeUrlParameters($values): self
    {
        $this->urlParameters = array_merge($this->urlParameters, (array) $values);
        return $this;
    }

    /**
     * @throws ValidationFailedException
     */
    protected function throwIfEmptyInput(): void
    {
        if (!count($this->post())) {
            throw new ValidationFailedException(__('ship::exception.empty_update_data'));
        }
    }

    protected function decodeHashedIdsBeforeValidation(array $requestData): array
    {
        try {
            return parent::decodeHashedIdsBeforeValidation($requestData);
        } catch (IncorrectIdException $exception) {
            return [];
        }
    }
}
