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

namespace App\Containers\OrganizationSection\UnitPrice\Map;

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AppSection\User\Models\User;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;
use App\Ship\Contracts\Namebled;
use App\Ship\Parents\Models\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Type implements Namebled
{
    abstract public function getModelAccessor(): string;
    abstract public function getModelKey(): string;

    public function noExistsModelIdValidationMessage(): string
    {
        return Container::trans('container.' . $this->getModelKey() . '.no_exists_model_id');
    }

    public function existsModelId(int|string $id): bool
    {
        return DB::table($this->getModel()->getTable())
            ->where(ID, $id)
            ->where(Contract::ORGANIZATION_ID, $this->user()->organization_id)
            ->exists();
    }

    public function getModel(): Model
    {
        return app($this->getModelAccessor());
    }

    protected function user(): User
    {
        return Auth::user();
    }
}
