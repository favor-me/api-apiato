<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\ShiftSection\Shift\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationBranch\Traits\OrganizationBranchValidationRules;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Traits\ShiftValidationRules;
use App\Containers\ShiftSection\Shift\UI\API\Transformers\ShiftTransformerManager;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use App\Ship\Support\Carbon;

/**
 * @property-read mixed $created_by
 * @property-read mixed $organization_id
 * @property-read mixed $organization_branch_id
 */
abstract class ShiftApiRequest extends ApiRequest implements GettableTransformer
{
    use ShiftValidationRules;
    use HasUserValidationRules;
    use OrganizationValidationRules;
    use OrganizationBranchValidationRules;

    protected array $decode = [
        CREATED_BY,
        Shift::ORGANIZATION_ID,
        Shift::ORGANIZATION_BRANCH_ID
    ];

    public function getTransformer(): Transformer
    {
        return (new ShiftTransformerManager())->getDefaultOrAdmin();
    }

    public function messages(): array
    {
        $tomorrow = Carbon::tomorrow()->utc();

        $beforeOrEqualLangAttrs = [
            'date' => $tomorrow->toSystemDateString()
        ];

        return [
            Shift::START_AT . '.before_or_equal' => Container::trans(
                'container.validation.' . Shift::START_AT . '.before_or_equal',
                $beforeOrEqualLangAttrs
            ),
            Shift::FINISH_AT . '.before_or_equal' => Container::trans(
                'container.validation.' . Shift::FINISH_AT . '.before_or_equal',
                $beforeOrEqualLangAttrs
            ),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->prepareData());
    }

    protected function prepareData(): array
    {
        $data = [
            Shift::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ];

        if (!$this->has(CREATED_BY)) {
            $data[CREATED_BY] = $this->user()->getHashedKey();
        }

        if (!$this->has(Shift::ORGANIZATION_BRANCH_ID)) {
            $data[Shift::ORGANIZATION_BRANCH_ID] = $this->user()->getHashedKey(User::ORGANIZATION_BRANCH_ID);
        }

        return $data;
    }
}
