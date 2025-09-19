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

namespace App\Containers\OrderSection\Order\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\OrderSection\Order\Models\Order;
use App\Containers\OrderSection\Order\Dto\CreateOrderDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateOrderTask extends OrderTask
{
    /**
     * @param CreateOrderDto $dto
     * @return Order
     * @throws CreateResourceFailedException
     */
    public function run(CreateOrderDto $dto): Order
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateOrderDto $dto
     * @return Order
     * @throws ValidatorException
     */
    protected function create(CreateOrderDto $dto): Order
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
