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

namespace App\Containers\AccountingSection\Contract\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AccountingSection\Contract\Dto\CreateContractDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateContractTask extends ContractTask
{
    /**
     * @param CreateContractDto $dto
     * @return Contract
     * @throws CreateResourceFailedException
     */
    public function run(CreateContractDto $dto): Contract
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateContractDto $dto
     * @return Contract
     * @throws ValidatorException
     */
    protected function create(CreateContractDto $dto): Contract
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
