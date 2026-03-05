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

namespace App\Containers\ShiftSection\Item\Data\Repositories;

use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method ItemModel getModel()
 */
final class ItemRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '='
    ];

    public function model(): string
    {
        return ItemModel::class;
    }
}
