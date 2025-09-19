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

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\OrderSection\Item\Models\Item;
use App\Containers\OrderSection\Item\Dto\UpdateItemDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateItemTask extends ItemTask
{
    /**
     * @param UpdateItemDto $dto
     * @return Item
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateItemDto $dto): Item
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateItemDto $dto
     * @return Item
     * @throws ValidatorException
     */
    protected function update(UpdateItemDto $dto): Item
    {
        $data = $dto
            ->except(ID)
            ->toArray(true);

        return $this->repository->update($data, $dto->id);
    }

    /**
     * @param Exception $exception
     * @throws UpdateResourceFailedException
     */
    protected function errorUpdate(Exception $exception): void
    {
        throw new UpdateResourceFailedException($exception->getMessage());
    }
}
