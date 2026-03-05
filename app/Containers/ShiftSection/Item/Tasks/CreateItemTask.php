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

namespace App\Containers\ShiftSection\Item\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\ShiftSection\Item\Models\Item;
use App\Containers\ShiftSection\Item\Dto\CreateItemDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateItemTask extends ItemTask
{
    /**
     * @param CreateItemDto $dto
     * @return Item
     * @throws CreateResourceFailedException
     */
    public function run(CreateItemDto $dto): Item
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateItemDto $dto
     * @return Item
     * @throws ValidatorException
     */
    protected function create(CreateItemDto $dto): Item
    {
        return $this->repository->create($dto->toArray());
    }

    /**
     * @param Exception $exception
     * @throws CreateResourceFailedException
     */
    protected function errorCreate(Exception $exception): void
    {
        throw new CreateResourceFailedException($exception->getMessage());
    }
}
