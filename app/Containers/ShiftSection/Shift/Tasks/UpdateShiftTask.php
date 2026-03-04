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

namespace App\Containers\ShiftSection\Shift\Tasks;

use App\Containers\ShiftSection\Shift\Dto\UpdateShiftDto;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateShiftTask extends ShiftTask
{
    /**
     * @param UpdateShiftDto $dto
     * @return Shift
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateShiftDto $dto): Shift
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateShiftDto $dto
     * @return Shift
     * @throws ValidatorException
     */
    protected function update(UpdateShiftDto $dto): Shift
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
