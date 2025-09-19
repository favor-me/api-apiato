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

namespace App\Containers\OrderSection\Item\Tasks;

use App\Ship\Exceptions\DeleteResourceFailedException;
use Exception;

class DeleteItemsTask extends ItemTask
{
    /**
     * @param array $ids
     * @return int
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): int
    {
        try {
            return $this->delete($ids);
        } catch (Exception) {
            throw new DeleteResourceFailedException();
        }
    }

    protected function delete(array $ids): int
    {
        $count = 0;
        collect($ids)
            ->each(function ($id) use (&$count) {
                $this->repository->delete($id);
                $count++;
            });

        return $count;
    }
}
