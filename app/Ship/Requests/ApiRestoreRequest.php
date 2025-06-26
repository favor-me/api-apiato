<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link        https://kalistratov.ru
 * @author      Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Requests;

use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Traits\Request\HasInputIds;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

abstract class ApiRestoreRequest extends ApiRequest
{
    use HasInputIds;

    protected array $decode = [
        IDS . '.*'
    ];

    public function getIdRules(): ValidationRulesCollection
    {
        return validation_rules([
            $this->existsRule()
        ])->addRequired();
    }

    abstract public function getTableName(): string;

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getIdRules()
        ];
    }

    protected function existsRule(): Exists
    {
        return Rule::exists($this->getTableName(), ID)
            ->whereNotNull(DELETED_AT);
    }
}
