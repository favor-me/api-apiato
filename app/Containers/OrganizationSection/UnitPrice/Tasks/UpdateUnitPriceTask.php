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

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Dto\UpdateUnitPriceDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateUnitPriceTask extends UnitPriceTask
{
    /**
     * @param UpdateUnitPriceDto $dto
     * @return UnitPrice
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateUnitPriceDto $dto): UnitPrice
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateUnitPriceDto $dto
     * @return UnitPrice
     * @throws ValidatorException
     */
    protected function update(UpdateUnitPriceDto $dto): UnitPrice
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
