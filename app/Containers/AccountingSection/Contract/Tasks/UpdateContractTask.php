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

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AccountingSection\Contract\Dto\UpdateContractDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class UpdateContractTask extends ContractTask
{
    /**
     * @param UpdateContractDto $dto
     * @return Contract
     * @throws UpdateResourceFailedException
     */
    public function run(UpdateContractDto $dto): Contract
    {
        try {
            return $this->update($dto);
        } catch (Exception $exception) {
            $this->errorUpdate($exception);
        }
    }

    /**
     * @param UpdateContractDto $dto
     * @return Contract
     * @throws ValidatorException
     */
    protected function update(UpdateContractDto $dto): Contract
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
