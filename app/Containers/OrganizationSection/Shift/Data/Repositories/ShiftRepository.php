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

namespace App\Containers\OrganizationSection\Shift\Data\Repositories;

use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * @method ShiftModel getModel()
 */
final class ShiftRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        CREATED_BY => 'in'
    ];

    public function model(): string
    {
        return ShiftModel::class;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws ValidatorException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function update(array $attributes, $id): mixed
    {
        $this->touchConfirmedAt($attributes);
        return parent::update($attributes, $id);
    }

    protected function touchConfirmedAt(array &$attributes): void
    {
        if (array_key_exists(CONFIRMED, $attributes) &&
            array_key_exists(Shift::CONFIRMED_BY, $attributes) &&
            $attributes[CONFIRMED] &&
            !empty(Shift::CONFIRMED_BY)
        ) {
            $attributes[Shift::CONFIRMED_AT] = now()->utc()->toDateTimeString();
            unset($attributes[CONFIRMED]);
        }
    }
}
