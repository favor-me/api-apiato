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

use App\Containers\ShiftSection\Shift\Dto\CreateShiftDto;
use App\Containers\ShiftSection\Shift\Models\Shift;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateShiftTask extends ShiftTask
{
    /**
     * @param CreateShiftDto $dto
     * @return Shift
     * @throws CreateResourceFailedException
     */
    public function run(CreateShiftDto $dto): Shift
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateShiftDto $dto
     * @return Shift
     * @throws ValidatorException
     */
    protected function create(CreateShiftDto $dto): Shift
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
