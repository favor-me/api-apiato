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

namespace App\Containers\CommunitySection\Counterparty\Tasks;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Counterparty\Dto\CreateCounterpartyDto;
use Prettus\Validator\Exceptions\ValidatorException;
use Exception;

class CreateCounterpartyTask extends CounterpartyTask
{
    /**
     * @param CreateCounterpartyDto $dto
     * @return Counterparty
     * @throws CreateResourceFailedException
     */
    public function run(CreateCounterpartyDto $dto): Counterparty
    {
        try {
            return $this->create($dto);
        } catch (Exception $exception) {
            $this->errorCreate($exception);
        }
    }

    /**
     * @param CreateCounterpartyDto $dto
     * @return Counterparty
     * @throws ValidatorException
     */
    protected function create(CreateCounterpartyDto $dto): Counterparty
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
