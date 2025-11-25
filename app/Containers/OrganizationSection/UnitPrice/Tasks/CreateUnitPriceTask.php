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

namespace App\Containers\OrganizationSection\UnitPrice\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Dto\CreateUnitPriceDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateUnitPriceTask extends UnitPriceTask
{
    /**
     * @param CreateUnitPriceDto $dto
     * @return UnitPrice
     * @throws CreateResourceFailedException
     */
    public function run(CreateUnitPriceDto $dto): UnitPrice
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateUnitPriceDto $dto
     * @return UnitPrice
     * @throws ValidatorException
     */
    protected function create(CreateUnitPriceDto $dto): UnitPrice
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
